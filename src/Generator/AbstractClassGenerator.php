<?php

declare(strict_types=1);

/*
 * Copyright (C) 2024 GT+ Logistics.
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301
 * USA
 */

namespace Gtlogistics\EdiX12\Generator;

use Webmozart\Assert\Assert;

use function Safe\mkdir;
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

    protected function assureDirExists(): void
    {
        if (!is_dir($this->getDirname())) {
            mkdir($this->getDirname(), 0755, true);
        }
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
