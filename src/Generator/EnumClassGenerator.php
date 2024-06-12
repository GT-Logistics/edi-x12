<?php

namespace Gtlogistics\X12Parser\Generator;

use Gtlogistics\X12Parser\Schema\Types\EnumType;
use Laminas\Code\Generator\EnumGenerator\EnumGenerator;
use Laminas\Code\Generator\FileGenerator;
use function Symfony\Component\String\u;

final readonly class EnumClassGenerator extends AbstractClassGenerator
{
    public function __construct(
        string $outputPath,
        string $namespace,
        private EnumType $enumType,
    ) {
        $className = u($enumType->getName())->camel()->title();

        parent::__construct($outputPath, $namespace, $className);
    }

    public function write(): void
    {
        $cases = [];
        foreach ($this->enumType->getAvailableValues() as $value => $description) {
            $key = u($description)->snake()->upper()->toString() ?: $value;
            $key = $this->escapeIdentifier($key);

            $cases[$key] = $value;
        }

        $enum = EnumGenerator::withConfig([
            'name' => $this->getFullClassName(),
            'backedCases' => [
                'type' => $this->enumType->getNativeType(),
                'cases' => $cases,
            ],
        ]);
        $file = (new FileGenerator())->setBody($enum->generate())->setFilename($this->getFilename());

        $file->write();
    }

    public function getNamespace(): string
    {
        return parent::getNamespace() . '\\' . 'Qualifier';
    }

    public function getDirname(): string
    {
        return parent::getDirname() . DIRECTORY_SEPARATOR . 'Qualifier';
    }
}
