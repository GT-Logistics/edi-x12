<?php

namespace Gtlogistics\X12Parser\Generator;

use Gtlogistics\X12Parser\Model\AbstractRelease;
use Gtlogistics\X12Parser\Schema\Release;
use Laminas\Code\Generator\AbstractMemberGenerator;
use Laminas\Code\Generator\ClassGenerator;
use Laminas\Code\Generator\FileGenerator;
use Laminas\Code\Generator\MethodGenerator;
use Laminas\Code\Generator\ParameterGenerator;

final readonly class ReleaseGenerator extends AbstractClassGenerator
{
    public function __construct(
        string $outputPath,
        string $namespace,
        private Release $release,
    ) {
        parent::__construct($outputPath, $namespace, "Release{$release->getId()}");
    }

    public function write(): void
    {
        $class = new ClassGenerator($this->getClassName(), $this->getNamespace());
        $file = (new FileGenerator())->setClass($class)->setFilename($this->getFilename());

        $classMap = new ClassMap();
        foreach ($this->release->getTransactionSets() as $transactionSet) {
            $transactionSetGenerator = new TransactionSetClassGenerator($this->getRootDirname(), $this->getRootNamespace(), $classMap, $transactionSet);

            $transactionSetGenerator->write();
        }

        $class->setExtendedClass(AbstractRelease::class);
        $class->addMethodFromGenerator(new MethodGenerator(
            '__construct',
            [
                new ParameterGenerator('transactionSetClassMap', 'array', $classMap->getTransactionSetClassMap()),
                new ParameterGenerator('segmentClassMap', 'array', $classMap->getSegmentClassMap()),
            ],
            AbstractMemberGenerator::FLAG_PUBLIC,
            'parent::__construct($transactionSetClassMap, $segmentClassMap);'
        ));

        $file->write();
    }
}
