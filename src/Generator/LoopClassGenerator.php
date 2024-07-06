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
use Laminas\Code\Generator\ClassGenerator;
use Laminas\Code\Generator\DocBlockGenerator;
use Laminas\Code\Generator\FileGenerator;
use Laminas\Code\Generator\MethodGenerator;

final readonly class LoopClassGenerator extends AbstractClassGenerator
{
    use RegisterSegmentTrait;

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
        $loopId = $this->loop->getId();

        $docBlock = (new DocBlockGenerator())->setWordWrap(false);
        $class = new ClassGenerator($this->getClassName(), $this->getNamespace(), docBlock: $docBlock);
        $file = (new FileGenerator())->setClass($class)->setFilename($this->getFilename());

        $class->setExtendedClass(AbstractLoop::class);

        $getIdMethod = new MethodGenerator('getId', body: "return '$loopId';");
        $getIdMethod->setReturnType('string');
        $class->addMethodFromGenerator($getIdMethod);

        $segments = $this->loop->getSegments();
        $this->registerSegments($class, $docBlock, $segments);

        $file->write();
    }
}
