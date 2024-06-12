<?php

namespace Gtlogistics\X12Parser\Generator;

use Gtlogistics\X12Parser\Model\AbstractSegment;
use Gtlogistics\X12Parser\Schema\Element;
use Gtlogistics\X12Parser\Schema\Segment;
use Gtlogistics\X12Parser\Schema\Types\DateType;
use Gtlogistics\X12Parser\Schema\Types\EnumType;
use Gtlogistics\X12Parser\Schema\Types\StringType;
use Gtlogistics\X12Parser\Schema\Types\TimeType;
use Laminas\Code\Generator\AbstractMemberGenerator;
use Laminas\Code\Generator\ClassGenerator;
use Laminas\Code\Generator\DocBlock\Tag\PropertyTag;
use Laminas\Code\Generator\DocBlockGenerator;
use Laminas\Code\Generator\FileGenerator;
use Laminas\Code\Generator\PropertyGenerator;
use Laminas\Code\Generator\TypeGenerator;

final readonly class SegmentClassGenerator extends AbstractClassGenerator
{
    public function __construct(
        string $outputPath,
        string $namespace,
        private Segment $segment,
    ) {
        parent::__construct($outputPath, $namespace, "{$segment->getId()}Segment");
    }

    public function getNamespace(): string
    {
        return parent::getNamespace() . '\\' . 'Segment';
    }

    public function getDirname(): string
    {
        return parent::getDirname() . DIRECTORY_SEPARATOR . 'Segment';
    }

    public function write(): void
    {
        $docblock = (new DocBlockGenerator())->setWordWrap(false);
        $class = new ClassGenerator($this->getClassName(), $this->getNamespace(), extends: AbstractSegment::class, docBlock: $docblock);
        $file = (new FileGenerator())->setClass($class)->setFilename($this->getFilename());

        $castings = [];
        $elements = $this->segment->getElements();
        foreach ($elements as $element) {
            $elementType = $element->getType();
            [$elementId, $elementNativeType] = $this->registerElement($docblock, $element);

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

        $file->write();
    }

    private function registerElement(DocBlockGenerator $docBlock, Element $element): array
    {
        $elementId = $this->segment->getId() . $element->getId();

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

        return [$elementId, $nativeType];
    }
}
