<?php

namespace Gtlogistics\X12Parser\Generator;

use Gtlogistics\X12Parser\Model\AbstractLoop;
use Gtlogistics\X12Parser\Schema\Loop;
use Gtlogistics\X12Parser\Schema\Segment;
use Laminas\Code\Generator\ClassGenerator;
use Laminas\Code\Generator\DocBlock\Tag\PropertyTag;
use Laminas\Code\Generator\DocBlockGenerator;
use Laminas\Code\Generator\FileGenerator;

final readonly class LoopClassGenerator extends AbstractClassGenerator
{
    public function __construct(
        string $outputPath,
        string $namespace,
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
        foreach ($segments as $segment) {
            $segmentId = $segment->getId();
            $generator = match (true) {
                $segment instanceof Loop => new LoopClassGenerator($this->getRootDirname(), $this->getRootNamespace(), $segment),
                $segment instanceof Segment => new SegmentClassGenerator($this->getRootDirname(), $this->getRootNamespace(), $segment),
                default => throw new \RuntimeException('Unsupported segment ' . $segment->getId()),
            };

            $class->addUse($generator->getFullClassName());
            $docBlock->setTag(new PropertyTag($segmentId, $generator->getClassName()));

            $generator->write();
        }

        $file->write();
    }
}
