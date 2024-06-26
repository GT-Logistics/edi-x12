<?php

declare(strict_types=1);

namespace Gtlogistics\X12Parser\Generator;

use Gtlogistics\X12Parser\Model\AbstractSegment;
use Gtlogistics\X12Parser\Schema\Segment;
use Laminas\Code\Generator\ClassGenerator;
use Laminas\Code\Generator\DocBlockGenerator;
use Laminas\Code\Generator\FileGenerator;
use Laminas\Code\Generator\MethodGenerator;

final readonly class SegmentClassGenerator extends AbstractClassGenerator
{
    use RegisterElementTrait;

    public function __construct(
        string $outputPath,
        string $namespace,
        private ClassMap $classMap,
        private Segment $segment,
    ) {
        parent::__construct($outputPath, $namespace, "{$segment->getId()}Segment");
    }

    public function getNamespace(): string
    {
        return parent::getNamespace() . '\\Segment';
    }

    public function getDirname(): string
    {
        return parent::getDirname() . DIRECTORY_SEPARATOR . 'Segment';
    }

    public function write(): void
    {
        $segmentId = $this->segment->getId();
        $this->classMap->addSegmentClass($segmentId, $this->getFullClassName());

        if (file_exists($this->getFilename())) {
            return;
        }

        $docblock = (new DocBlockGenerator())->setWordWrap(false);
        $class = new ClassGenerator($this->getClassName(), $this->getNamespace(), docBlock: $docblock);
        $file = (new FileGenerator())->setClass($class)->setFilename($this->getFilename());

        $class->setExtendedClass(AbstractSegment::class);

        $getIdMethod = new MethodGenerator('getId', body: "return '$segmentId';");
        $getIdMethod->setReturnType('string');
        $class->addMethodFromGenerator($getIdMethod);

        $elements = $this->segment->getElements();
        $this->registerElements($class, $docblock, $elements);

        $file->write();
    }
}
