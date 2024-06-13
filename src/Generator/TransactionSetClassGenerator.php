<?php

namespace Gtlogistics\X12Parser\Generator;

use Gtlogistics\X12Parser\Model\AbstractTransactionSet;
use Gtlogistics\X12Parser\Qualifier\TransactionSetIdentifierCode;
use Gtlogistics\X12Parser\Schema\Loop;
use Gtlogistics\X12Parser\Schema\Segment;
use Gtlogistics\X12Parser\Schema\TransactionSet;
use Laminas\Code\Generator\ClassGenerator;
use Laminas\Code\Generator\DocBlock\Tag\PropertyTag;
use Laminas\Code\Generator\DocBlockGenerator;
use Laminas\Code\Generator\FileGenerator;

final readonly class TransactionSetClassGenerator extends AbstractClassGenerator
{
    use RegisterElementTrait;

    public function __construct(
        string $outputPath,
        string $namespace,
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

        $class->addUse(TransactionSetIdentifierCode::class);
        $class->setExtendedClass(AbstractTransactionSet::class);

        $segments = $this->transactionSet->getSegments();
        foreach ($segments as $segment) {
            $segmentId = $segment->getId();

            if ($segment instanceof Segment && $segmentId === 'ST') {
                $elements = $segment->getElements();
                foreach ($elements as $element) {
                    $elementId = 'ST' . $element->getId();

                    $this->registerElement($docBlock, $element, $elementId);
                }

                continue;
            }

            $generator = match (true) {
                $segment instanceof Loop => new LoopClassGenerator($this->getRootDirname(), $this->getRootNamespace(), $segment),
                $segment instanceof Segment => new SegmentClassGenerator($this->getRootDirname(), $this->getRootNamespace(), $segment),
                default => throw new \RuntimeException('Unsupported segment ' . $segment->getId()),
            };

            $class->addUse($generator->getFullClassName());
            $docBlock->setTag(new PropertyTag($segmentId, $generator->getClassName() . '[]'));

            $generator->write();
        }

        $file->write();
    }
}
