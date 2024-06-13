<?php

namespace Gtlogistics\X12Parser\Generator;

use Gtlogistics\X12Parser\Schema\Element;
use Gtlogistics\X12Parser\Schema\Types\EnumType;
use Laminas\Code\Generator\DocBlock\Tag\PropertyTag;
use Laminas\Code\Generator\DocBlockGenerator;

trait RegisterElementTrait
{
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
