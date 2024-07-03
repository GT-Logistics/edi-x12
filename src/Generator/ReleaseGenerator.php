<?php

declare(strict_types=1);

namespace Gtlogistics\EdiX12\Generator;

use Gtlogistics\EdiX12\Model\AbstractRelease;
use Gtlogistics\EdiX12\Schema\Release;
use Laminas\Code\Generator\AbstractMemberGenerator;
use Laminas\Code\Generator\ClassGenerator;
use Laminas\Code\Generator\FileGenerator;
use Laminas\Code\Generator\MethodGenerator;
use Laminas\Code\Generator\ParameterGenerator;
use Laminas\Code\Generator\PropertyGenerator;
use Laminas\Code\Generator\TypeGenerator;

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
        $class->addPropertyFromGenerator(new PropertyGenerator(
            'transactionSetClassMap',
            $classMap->getTransactionSetClassMap(),
            AbstractMemberGenerator::FLAG_PROTECTED,
            TypeGenerator::fromTypeString('array'),
        ));
        $class->addPropertyFromGenerator(new PropertyGenerator(
            'segmentClassMap',
            $classMap->getSegmentClassMap(),
            AbstractMemberGenerator::FLAG_PROTECTED,
            TypeGenerator::fromTypeString('array'),
        ));

        $supportsMethod = new MethodGenerator(
            'supports',
            [new ParameterGenerator('releaseId', 'string')],
            body: "return \$releaseId === '{$this->release->getId()}';",
        );
        $supportsMethod->setReturnType('bool');
        $class->addMethodFromGenerator($supportsMethod);

        $file->write();
    }
}
