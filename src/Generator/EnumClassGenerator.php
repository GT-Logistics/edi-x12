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

use Gtlogistics\EdiX12\Schema\Types\EnumType;
use Laminas\Code\Generator\EnumGenerator\EnumGenerator;
use Laminas\Code\Generator\FileGenerator;
use Webmozart\Assert\Assert;

use function Symfony\Component\String\u;

final readonly class EnumClassGenerator extends AbstractClassGenerator
{
    public function __construct(
        string $outputPath,
        string $namespace,
        private EnumType $enumType,
    ) {
        $className = u($enumType->getName())->camel()->title()->toString();

        parent::__construct($outputPath, $namespace, $className);
    }

    public function write(): void
    {
        if (file_exists($this->getFilename())) {
            return;
        }

        $cases = [];
        foreach ($this->enumType->getAvailableValues() as $value => $description) {
            $key = u($description)->snake()->upper()->toString() ?: (string) $value;
            $key = $this->escapeIdentifier($key);

            Assert::stringNotEmpty($key);

            $cases[$key] = $value;
        }

        $enum = EnumGenerator::withConfig([
            'name' => $this->getFullClassName(),
            'backedCases' => [
                'type' => $this->enumType->getNativeType(),
                'cases' => $cases,
            ],
        ]);
        $file = (new FileGenerator())->setBody($enum->generate())->setFilename($this->getFilename());

        $file->write();
    }

    public function getNamespace(): string
    {
        return parent::getNamespace() . '\\Qualifier';
    }

    public function getDirname(): string
    {
        return parent::getDirname() . DIRECTORY_SEPARATOR . 'Qualifier';
    }
}
