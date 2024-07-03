<?php

declare(strict_types=1);

namespace Gtlogistics\EdiX12\Generator;

use Webmozart\Assert\Assert;

use function Symfony\Component\String\u;

abstract readonly class AbstractClassGenerator implements ClassGeneratorInterface
{
    /**
     * @var non-empty-string
     */
    private string $outputPath;

    /**
     * @var non-empty-string
     */
    private string $namespace;

    /**
     * @var non-empty-string
     */
    private string $className;

    public function __construct(
        string $outputPath,
        string $namespace,
        string $className,
    ) {
        Assert::stringNotEmpty($outputPath);
        Assert::directory($outputPath);
        Assert::stringNotEmpty($namespace);
        Assert::stringNotEmpty($className);

        $this->outputPath = $outputPath;
        $this->namespace = $namespace;
        $this->className = $className;
    }

    /**
     * @return non-empty-string
     */
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

    /**
     * @return non-empty-string
     */
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
        $identifier = u($identifier)->ascii()->toString();

        if (is_numeric($identifier[0])) {
            $identifier = '_' . $identifier;
        }

        return $identifier;
    }
}
