<?php

declare(strict_types=1);

namespace Gtlogistics\X12Parser\Generator;

use Gtlogistics\X12Parser\Model\AbstractTransactionSet;
use Gtlogistics\X12Parser\Schema\Segment;
use Gtlogistics\X12Parser\Schema\TransactionSet;
use Laminas\Code\Generator\ClassGenerator;
use Laminas\Code\Generator\DocBlockGenerator;
use Laminas\Code\Generator\FileGenerator;
use Laminas\Code\Generator\MethodGenerator;

final readonly class TransactionSetClassGenerator extends AbstractClassGenerator
{
    use RegisterElementTrait;
    use RegisterSegmentTrait;

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
        return parent::getNamespace() . '\\TransactionSet';
    }

    public function write(): void
    {
        $transactionSetCode = $this->transactionSet->getCode();
        $this->classMap->addTransactionSetClass($transactionSetCode, $this->getFullClassName());

        $docBlock = (new DocBlockGenerator())->setWordWrap(false);
        $class = new ClassGenerator($this->getClassName(), $this->getNamespace(), docBlock: $docBlock);
        $file = (new FileGenerator())->setClass($class)->setFilename($this->getFilename());

        $class->setExtendedClass(AbstractTransactionSet::class);

        $getIdMethod = new MethodGenerator('getId', body: "return 'ST';");
        $getIdMethod->setReturnType('string');
        $class->addMethodFromGenerator($getIdMethod);

        $segments = $this->transactionSet->getSegments();
        $stSegment = array_shift($segments);

        if (!($stSegment instanceof Segment) || $stSegment->getId() !== 'ST') {
            throw new \RuntimeException('Unexpected segment');
        }

        $this->registerElements($class, $docBlock, $stSegment->getElements());
        $this->registerSegments($class, $docBlock, $segments);

        $file->write();
    }
}
