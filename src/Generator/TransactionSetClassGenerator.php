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

use Gtlogistics\EdiX12\Model\AbstractTransactionSet;
use Gtlogistics\EdiX12\Schema\Segment;
use Gtlogistics\EdiX12\Schema\TransactionSet;
use Laminas\Code\Generator\ClassGenerator;
use Laminas\Code\Generator\DocBlockGenerator;
use Laminas\Code\Generator\FileGenerator;
use Laminas\Code\Generator\MethodGenerator;

final readonly class TransactionSetClassGenerator extends AbstractClassGenerator
{
    use RegisterElementTrait;
    use RegisterSegmentTrait;

    public function __construct(
        string $outputPath,
        string $namespace,
        private ClassMap $classMap,
        private TransactionSet $transactionSet,
    ) {
        parent::__construct($outputPath, $namespace, "TransactionSet{$transactionSet->getCode()}");
    }

    protected function getDirname(): string
    {
        return parent::getDirname() . DIRECTORY_SEPARATOR . 'TransactionSet';
    }

    public function getNamespace(): string
    {
        return parent::getNamespace() . '\\TransactionSet';
    }

    public function write(): void
    {
        $transactionSetCode = $this->transactionSet->getCode();
        $this->classMap->addTransactionSetClass($transactionSetCode, $this->getFullClassName());

        $docBlock = (new DocBlockGenerator())->setWordWrap(false);
        $class = new ClassGenerator($this->getClassName(), $this->getNamespace(), docBlock: $docBlock);
        $file = (new FileGenerator())->setClass($class)->setFilename($this->getFilename());

        $class->setExtendedClass(AbstractTransactionSet::class);

        $getIdMethod = new MethodGenerator('getId', body: "return 'ST';");
        $getIdMethod->setReturnType('string');
        $class->addMethodFromGenerator($getIdMethod);

        $segments = $this->transactionSet->getSegments();
        $stSegment = array_shift($segments);

        if (!($stSegment instanceof Segment) || $stSegment->getId() !== 'ST') {
            throw new \RuntimeException('Unexpected segment');
        }

        $this->registerElements($class, $docBlock, $stSegment->getElements());
        $this->registerSegments($class, $docBlock, $segments);

        $file->write();
    }
}
