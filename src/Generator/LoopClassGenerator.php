<?php

namespace Gtlogistics\X12Parser\Generator;

use Gtlogistics\X12Parser\Model\AbstractLoop;
use Gtlogistics\X12Parser\Schema\Loop;
use Laminas\Code\Generator\ClassGenerator;
use Laminas\Code\Generator\DocBlockGenerator;
use Laminas\Code\Generator\FileGenerator;

final readonly class LoopClassGenerator extends AbstractClassGenerator
{
    use RegisterSegmentTrait;

    public function __construct(
        string $outputPath,
        string $namespace,
        private ClassMap $classMap,
        private Loop $loop,
    ) {
        parent::__construct($outputPath, $namespace, $loop->getId());
    }

    public function getNamespace(): string
    {
        return parent::getNamespace() . '\\' . 'Loop';
    }

    public function getDirname(): string
    {
        return parent::getDirname() . DIRECTORY_SEPARATOR . 'Loop';
    }

    public function write(): void
    {
        $docBlock = (new DocBlockGenerator())->setWordWrap(false);
        $class = new ClassGenerator($this->getClassName(), $this->getNamespace(), docBlock: $docBlock);
        $file = (new FileGenerator())->setClass($class)->setFilename($this->getFilename());

        $class->setExtendedClass(AbstractLoop::class);

        $segments = $this->loop->getSegments();
        $this->registerSegments($class, $docBlock, $segments);

        $file->write();
    }
}
