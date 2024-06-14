<?php

namespace Gtlogistics\X12Parser\Generator;

use Gtlogistics\X12Parser\Schema\Element;
use Gtlogistics\X12Parser\Schema\Types\DateType;
use Gtlogistics\X12Parser\Schema\Types\EnumType;
use Gtlogistics\X12Parser\Schema\Types\StringType;
use Gtlogistics\X12Parser\Schema\Types\TimeType;
use Laminas\Code\Generator\AbstractMemberGenerator;
use Laminas\Code\Generator\ClassGenerator;
use Laminas\Code\Generator\DocBlock\Tag\PropertyTag;
use Laminas\Code\Generator\DocBlockGenerator;
use Laminas\Code\Generator\PropertyGenerator;
use Laminas\Code\Generator\TypeGenerator;

trait RegisterElementTrait
{
    private function registerElements(ClassGenerator $class, DocBlockGenerator $docBlock, array $elements, string $segmentId): void
    {
        $castings = [];
        foreach ($elements as $element) {
            $elementId = '_' . $element->getId();
            $elementType = $element->getType();
            $elementNativeType = $this->registerElement($docBlock, $element, $elementId);

            if (class_exists($elementNativeType) || interface_exists($elementNativeType)) {
                $class->addUse($elementNativeType);
            }

            if (!($elementType instanceof StringType)) {
                $castings[$elementId] = match (true) {
                    $elementType instanceof DateType => 'date',
                    $elementType instanceof TimeType => 'time',
                    default => $elementNativeType,
                };
            }
        }

        if (count($castings) !== 0) {
            $castingProperty = new PropertyGenerator('castings', $castings, AbstractMemberGenerator::FLAG_PROTECTED, TypeGenerator::fromTypeString('array'));
            $class->addPropertyFromGenerator($castingProperty);
        }
    }

    private function registerElement(DocBlockGenerator $docBlock, Element $element, string $elementId): string
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
            $elementId,
            $docBlockTypes,
            $description,
        ));

        return $nativeType;
    }
}