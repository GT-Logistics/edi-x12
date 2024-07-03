<?php

declare(strict_types=1);

namespace Gtlogistics\EdiX12\Generator;

use Gtlogistics\EdiX12\Schema\Element;
use Gtlogistics\EdiX12\Schema\Types\DateType;
use Gtlogistics\EdiX12\Schema\Types\EnumType;
use Gtlogistics\EdiX12\Schema\Types\StringType;
use Gtlogistics\EdiX12\Schema\Types\TimeType;
use Laminas\Code\Generator\AbstractMemberGenerator;
use Laminas\Code\Generator\ClassGenerator;
use Laminas\Code\Generator\DocBlock\Tag\PropertyTag;
use Laminas\Code\Generator\DocBlockGenerator;
use Laminas\Code\Generator\PropertyGenerator;
use Laminas\Code\Generator\TypeGenerator;

use function Symfony\Component\String\u;

trait RegisterElementTrait
{
    /**
     * @param Element[] $elements
     */
    private function registerElements(ClassGenerator $class, DocBlockGenerator $docBlock, array $elements): void
    {
        $aliases = [];
        $castings = [];
        $lengths = [];
        $required = [];
        foreach ($elements as $element) {
            $elementIndex = $element->getIndex();
            $elementDescription = $element->getDescription();
            $elementType = $element->getType();

            $shortElementId = '_' . str_pad((string) $elementIndex, 2, '0', STR_PAD_LEFT);
            $longElementId = $this->escapeIdentifier(u($elementDescription)->camel()->toString()) . $shortElementId;
            $elementNativeType = $this->registerElement($docBlock, $element, $shortElementId, $longElementId);

            if (class_exists($elementNativeType) || interface_exists($elementNativeType)) {
                $class->addUse($elementNativeType);
            }

            $aliases[$longElementId] = $elementIndex;

            if (!($elementType instanceof StringType)) {
                $castings[$elementIndex] = match (true) {
                    $elementType instanceof DateType => 'date',
                    $elementType instanceof TimeType => 'time',
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

        if (count($aliases) !== 0) {
            $aliasesProperty = new PropertyGenerator('aliases', $aliases, AbstractMemberGenerator::FLAG_PROTECTED, TypeGenerator::fromTypeString('array'));
            $class->addPropertyFromGenerator($aliasesProperty);
        }

        if (count($castings) !== 0) {
            $castingsProperty = new PropertyGenerator('castings', $castings, AbstractMemberGenerator::FLAG_PROTECTED, TypeGenerator::fromTypeString('array'));
            $class->addPropertyFromGenerator($castingsProperty);
        }

        if (count($lengths) !== 0) {
            $lengthsProperty = new PropertyGenerator('lengths', $lengths, AbstractMemberGenerator::FLAG_PROTECTED, TypeGenerator::fromTypeString('array'));
            $class->addPropertyFromGenerator($lengthsProperty);
        }

        if (count($required) !== 0) {
            $requiredProperty = new PropertyGenerator('required', $required, AbstractMemberGenerator::FLAG_PROTECTED, TypeGenerator::fromTypeString('array'));
            $class->addPropertyFromGenerator($requiredProperty);
        }
    }

    private function registerElement(DocBlockGenerator $docBlock, Element $element, string $shortElementId, string $longElementId): string
    {
        $docBlockTypes = [];
        $type = $element->getType();
        $nativeType = $type->getNativeType();
        $description = $element->getDescription();

        if ($type instanceof EnumType) {
            $enumGenerator = new EnumClassGenerator($this->getRootDirname(), $this->getRootNamespace(), $type);

            $nativeType = $enumGenerator->getFullClassName();
            $docBlockTypes[] = $enumGenerator->getClassName();

            $enumGenerator->write();
        } else {
            $docBlockTypes[] = $nativeType;
        }

        if (!$element->isRequired()) {
            $docBlockTypes[] = 'null';
        }

        $docBlock->setTag(new PropertyTag(
            $shortElementId,
            $docBlockTypes,
            $description,
        ));
        $docBlock->setTag(new PropertyTag(
            $longElementId,
            $docBlockTypes,
            $description,
        ));

        return $nativeType;
    }
}
