<?php

declare(strict_types=1);

/*
 * Copyright (C) 2024 GT+ Logistics.
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301
 * USA
 */

namespace Gtlogistics\EdiX12\Generator;

use Gtlogistics\EdiX12\Schema\Element;
use Gtlogistics\EdiX12\Schema\Types\DateType;
use Gtlogistics\EdiX12\Schema\Types\EnumType;
use Gtlogistics\EdiX12\Schema\Types\StringType;
use Gtlogistics\EdiX12\Schema\Types\TimeType;
use Nette\PhpGenerator\ClassType;
use Nette\PhpGenerator\Literal;
use Nette\PhpGenerator\PhpNamespace;

use function Symfony\Component\String\u;

trait RegisterElementNetteTrait
{
    /**
     * @param Element[] $elements
     */
    private function registerElements(PhpNamespace $namespace, ClassType $class, array $elements): void
    {
        $castings = [];
        $lengths = [];
        $required = [];
        foreach ($elements as $element) {
            $elementIndex = $element->getIndex();
            $elementDescription = $element->getDescription();
            $elementType = $element->getType();

            $shortElementId = '_' . str_pad((string) $elementIndex, 2, '0', STR_PAD_LEFT);
            $longElementId = $this->escapeIdentifier(u($elementDescription)->camel()->toString()) . $shortElementId;
            $elementNativeType = $this->registerElement($namespace, $class, $element, $shortElementId, $longElementId);

            $aliases[$longElementId] = $elementIndex;

            if (!($elementType instanceof StringType)) {
                $castings[$elementIndex] = match (true) {
                    $elementType instanceof DateType => 'date',
                    $elementType instanceof TimeType => 'time',
                    $elementType instanceof EnumType => new Literal($elementNativeType . '::class'),
                    default => $elementNativeType,
                };
            }

            $minLength = $element->getMinLength();
            $maxLength = $element->getMaxLength();
            if ($minLength !== -1 && $maxLength !== -1) {
                $lengths[$elementIndex] = [$minLength, $maxLength];
            }

            $isRequired = $element->isRequired();
            if ($isRequired) {
                $required[$elementIndex] = true;
            }
        }

        if (count($castings) !== 0) {
            $class->addProperty('castings', $castings)->setProtected()->setType('array');
        }

        if (count($lengths) !== 0) {
            $class->addProperty('lengths', $lengths)->setProtected()->setType('array');
        }

        if (count($required) !== 0) {
            $class->addProperty('required', $required)->setProtected()->setType('array');
        }
    }

    private function registerElement(PhpNamespace $namespace, ClassType $class, Element $element, string $shortElementId, string $longElementId): string
    {
        $docBlockTypes = [];
        $type = $element->getType();
        $nativeType = $type->getNativeType();
        $description = $element->getDescription();

        if ($type instanceof EnumType) {
            $enumGenerator = new EnumClassGenerator($this->getRootDirname(), $this->getRootNamespace(), $type);
            $nativeType = $enumGenerator->getClassName();

            $namespace->addUse($enumGenerator->getFullClassName());
            $enumGenerator->write();
        } elseif ($type instanceof DateType || $type instanceof TimeType) {
            $namespace->addUse($nativeType);
        }
        $docBlockTypes[] = $nativeType;

        if (!$element->isRequired()) {
            $docBlockTypes[] = 'null';
        }

        $class->addComment(sprintf('@property %s $%s %s', implode('|', $docBlockTypes), $longElementId, $description));
        $class->addComment(sprintf('@property %s $%s %s', implode('|', $docBlockTypes), $shortElementId, "See $$longElementId"));

        return $nativeType;
    }
}
