<?php

namespace Gtlogistics\X12Parser\Generator;

use Gtlogistics\X12Parser\Model\AbstractTransactionSet;
use Gtlogistics\X12Parser\Schema\Loop;
use Gtlogistics\X12Parser\Schema\Segment;
use Gtlogistics\X12Parser\Schema\TransactionSet;
use Laminas\Code\Generator\AbstractMemberGenerator;
use Laminas\Code\Generator\ClassGenerator;
use Laminas\Code\Generator\DocBlock\Tag\PropertyTag;
use Laminas\Code\Generator\DocBlockGenerator;
use Laminas\Code\Generator\FileGenerator;
use Laminas\Code\Generator\MethodGenerator;
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
        parent::__construct($outputPath, $namespace, "TransactionSet{$transactionSet->getCode()}");
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
        $transactionSetCode = $this->transactionSet->getCode();

        $class->setExtendedClass(AbstractTransactionSet::class);

        $getIdMethod = new MethodGenerator('getId', body: "return 'ST';");
        $getIdMethod->setReturnType('string');
        $class->addMethodFromGenerator($getIdMethod);

        $this->classMap->addTransactionSetClass($transactionSetCode, $this->getFullClassName());

        $loops = [];
        $segments = $this->transactionSet->getSegments();
        foreach ($segments as $segment) {
            $segmentId = $segment->getId();

            if ($segment instanceof Segment && $segmentId === 'ST') {
                $elements = $segment->getElements();
                $this->registerElements($class, $docBlock, $elements);

                continue;
            }

            $generator = match (true) {
                $segment instanceof Loop => new LoopClassGenerator($this->getRootDirname(), $this->getRootNamespace(), $this->classMap, $segment),
                $segment instanceof Segment => new SegmentClassGenerator($this->getRootDirname(), $this->getRootNamespace(), $this->classMap, $segment),
                default => throw new \RuntimeException('Unsupported segment ' . $segment->getId()),
            };

            if ($generator instanceof LoopClassGenerator) {
                $loops[] = $generator->getFullClassName();
            }

            $class->addUse($generator->getFullClassName());
            $docBlock->setTag(new PropertyTag($segmentId, $generator->getClassName() . '[]'));

            $generator->write();
        }

        if (count($loops) > 0) {
            $loopsProperty = new PropertyGenerator('loops', $loops, AbstractMemberGenerator::FLAG_PROTECTED, TypeGenerator::fromTypeString('array'));
            $class->addPropertyFromGenerator($loopsProperty);
        }

        $file->write();
    }
}
