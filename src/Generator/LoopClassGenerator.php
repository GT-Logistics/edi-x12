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

use Gtlogistics\EdiX12\Model\AbstractLoop;
use Gtlogistics\EdiX12\Schema\Loop;
use Gtlogistics\EdiX12\Schema\TransactionSet;
use Nette\PhpGenerator\PhpFile;

use function Safe\file_put_contents;

final readonly class LoopClassGenerator extends AbstractClassGenerator
{
    use RegisterSegmentNetteTrait;

    public function __construct(
        string $outputPath,
        string $namespace,
        private ClassMap $classMap,
        private TransactionSet $transactionSet,
        private Loop $loop,
    ) {
        parent::__construct($outputPath, $namespace, "{$loop->getId()}_{$transactionSet->getCode()}");
    }

    public function getNamespace(): string
    {
        return parent::getNamespace() . '\\Loop';
    }

    public function getDirname(): string
    {
        return parent::getDirname() . DIRECTORY_SEPARATOR . 'Loop';
    }

    public function write(): void
    {
        $this->assureDirExists();

        $loopId = $this->loop->getId();

        $file = new PhpFile();
        $namespace = $file->addNamespace($this->getNamespace());
        $class = $namespace->addClass($this->getClassName());

        $class->setExtends(AbstractLoop::class);

        $class->addMethod('getId')->setBody("return '$loopId';")->setReturnType('string');

        $segments = $this->loop->getSegments();
        $this->registerSegments($namespace, $class, $segments);

        file_put_contents($this->getFilename(), (string) $file);
    }
}
