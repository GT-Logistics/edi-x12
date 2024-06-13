<?php

namespace Gtlogistics\X12Parser\Generator;

use Gtlogistics\X12Parser\Model\AbstractTransactionSet;
use Gtlogistics\X12Parser\Schema\Loop;
use Gtlogistics\X12Parser\Schema\Segment;
use Gtlogistics\X12Parser\Schema\TransactionSet;
use Gtlogistics\X12Parser\Schema\Types\DateType;
use Gtlogistics\X12Parser\Schema\Types\StringType;
use Gtlogistics\X12Parser\Schema\Types\TimeType;
use Laminas\Code\Generator\AbstractMemberGenerator;
use Laminas\Code\Generator\ClassGenerator;
use Laminas\Code\Generator\DocBlock\Tag\PropertyTag;
use Laminas\Code\Generator\DocBlockGenerator;
use Laminas\Code\Generator\FileGenerator;
use Laminas\Code\Generator\PropertyGenerator;
use Laminas\Code\Generator\TypeGenerator;

final readonly class TransactionSetClassGenerator extends AbstractClassGenerator
{
    use RegisterElementTrait;

    public function __construct(
        string $outputPath,
        string $namespace,
        private ClassMap $classMap,
        private TransactionSet $transactionSet,
    ) {
        parent::__construct($outputPath, $namespace, "TransactionSet{$transactionSet->getId()}");
    }

    protected function getDirname(): string
    {
        return parent::getDirname() . DIRECTORY_SEPARATOR . 'TransactionSet';
    }

    public function getNamespace(): string
    {
        return parent::getNamespace() . '\\' . 'TransactionSet';
    }

    public function write(): void
    {
        $docBlock = (new DocBlockGenerator())->setWordWrap(false);
        $class = new ClassGenerator($this->getClassName(), $this->getNamespace(), docBlock: $docBlock);
        $file = (new FileGenerator())->setClass($class)->setFilename($this->getFilename());

        $class->setExtendedClass(AbstractTransactionSet::class);
        $this->classMap->addTransactionSetClass($this->transactionSet->getId(), $this->getFullClassName());

        $castings = [];
        $segments = $this->transactionSet->getSegments();
        foreach ($segments as $segment) {
            $segmentId = $segment->getId();

            if ($segment instanceof Segment && $segmentId === 'ST') {
                $elements = $segment->getElements();
                foreach ($elements as $element) {
                    $elementId = $segmentId . $element->getId();
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

                continue;
            }

            $generator = match (true) {
                $segment instanceof Loop => new LoopClassGenerator($this->getRootDirname(), $this->getRootNamespace(), $this->classMap, $segment),
                $segment instanceof Segment => new SegmentClassGenerator($this->getRootDirname(), $this->getRootNamespace(), $this->classMap, $segment),
                default => throw new \RuntimeException('Unsupported segment ' . $segment->getId()),
            };

            $class->addUse($generator->getFullClassName());
            $docBlock->setTag(new PropertyTag($segmentId, $generator->getClassName() . '[]'));

            $generator->write();
        }

        if (count($castings) !== 0) {
            $castingProperty = new PropertyGenerator('castings', $castings, AbstractMemberGenerator::FLAG_PROTECTED, TypeGenerator::fromTypeString('array'));
            $class->addPropertyFromGenerator($castingProperty);
        }

        $file->write();
    }
}
