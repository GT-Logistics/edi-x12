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

use Gtlogistics\EdiX12\Schema\Types\EnumType;
use Nette\PhpGenerator\Literal;
use Nette\PhpGenerator\PhpFile;

use function Safe\file_put_contents;
use function Symfony\Component\String\u;

/**
 * @extends AbstractClassGenerator<\BackedEnum>
 */
final readonly class EnumClassGenerator extends AbstractClassGenerator
{
    public function __construct(
        string $outputPath,
        string $namespace,
        private EnumType $enumType,
    ) {
        $className = u($enumType->getName())->camel()->title()->toString();

        parent::__construct($outputPath, $namespace, $className);
    }

    public function write(): void
    {
        $this->assureDirExists();

        if (file_exists($this->getFilename())) {
            return;
        }

        $file = new PhpFile();
        $namespace = $file->addNamespace($this->getNamespace());
        $enum = $namespace->addEnum($this->getClassName());

        foreach ($this->enumType->getAvailableValues() as $value => $description) {
            $value = (string) $value;
            $key = $this->escapeIdentifier($value);
            $case = $enum->addCase($key, $value);

            if ($description) {
                $key = $this->escapeIdentifier(u($description)->snake()->upper()->toString()) . '_' . $value;
                $alias = $enum->addConstant($key, new Literal('self::' . $case->getName()))->setType('self');

                $case->addComment('@see self::' . $alias->getName());
                $alias->addComment($description);
            }
        }

        file_put_contents($this->getFilename(), (string) $file);
    }

    public function getNamespace(): string
    {
        return parent::getNamespace() . '\\Qualifier';
    }

    public function getDirname(): string
    {
        return parent::getDirname() . DIRECTORY_SEPARATOR . 'Qualifier';
    }
}
