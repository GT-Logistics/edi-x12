<?php

namespace Gtlogistics\X12Parser\Generator;

abstract readonly class AbstractClassGenerator implements ClassGeneratorInterface
{
    public function __construct(
        private string $outputPath,
        private string $namespace,
        private string $className,
    ) {
    }

    protected function getRootNamespace(): string
    {
        return $this->namespace;
    }

    public function getNamespace(): string
    {
        return $this->getRootNamespace();
    }

    public function getClassName(): string
    {
        return $this->className;
    }

    public function getFullClassName(): string
    {
        return $this->getNamespace() . '\\' . $this->getClassName();
    }

    protected function getRootDirname(): string
    {
        return $this->outputPath;
    }

    protected function getDirname(): string
    {
        return $this->getRootDirname();
    }

    public function getFilename(): string
    {
        return $this->getDirname() . DIRECTORY_SEPARATOR . $this->getClassName() . '.php';
    }

    protected function escapeIdentifier(string $identifier): string
    {
        if (is_numeric($identifier[0])) {
            $identifier = '_' . $identifier;
        }

        return $identifier;
    }
}
