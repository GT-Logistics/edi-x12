<?php

declare(strict_types=1);

namespace Gtlogistics\X12Parser\Generator;

use Gtlogistics\X12Parser\Model\AbstractLoop;
use Gtlogistics\X12Parser\Schema\Loop;
use Gtlogistics\X12Parser\Schema\TransactionSet;
use Laminas\Code\Generator\ClassGenerator;
use Laminas\Code\Generator\DocBlockGenerator;
use Laminas\Code\Generator\FileGenerator;
use Laminas\Code\Generator\MethodGenerator;

final readonly class LoopClassGenerator extends AbstractClassGenerator
{
    use RegisterSegmentTrait;

    public function __construct(
        string $outputPath,
        string $namespace,
        private ClassMap $classMap,
        private TransactionSet $transactionSet,
        private Loop $loop,
    ) {
        parent::__construct($outputPath, $namespace, "{$loop->getId()}_{$transactionSet->getCode()}");
    }

    public function getNamespace(): string
    {
        return parent::getNamespace() . '\\Loop';
    }

    public function getDirname(): string
    {
        return parent::getDirname() . DIRECTORY_SEPARATOR . 'Loop';
    }

    public function write(): void
    {
        $loopId = $this->loop->getId();

        $docBlock = (new DocBlockGenerator())->setWordWrap(false);
        $class = new ClassGenerator($this->getClassName(), $this->getNamespace(), docBlock: $docBlock);
        $file = (new FileGenerator())->setClass($class)->setFilename($this->getFilename());

        $class->setExtendedClass(AbstractLoop::class);

        $getIdMethod = new MethodGenerator('getId', body: "return '$loopId';");
        $getIdMethod->setReturnType('string');
        $class->addMethodFromGenerator($getIdMethod);

        $segments = $this->loop->getSegments();
        $this->registerSegments($class, $docBlock, $segments);

        $file->write();
    }
}
