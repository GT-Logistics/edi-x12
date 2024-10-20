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
use Nette\PhpGenerator\PhpFile;

use function Safe\file_put_contents;

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
        $this->assureDirExists();

        $transactionSetCode = $this->transactionSet->getCode();
        $this->classMap->addTransactionSetClass($transactionSetCode, $this->getFullClassName());

        $file = new PhpFile();
        $namespace = $file->addNamespace($this->getNamespace());
        $class = $namespace->addClass($this->getClassName());

        $class->setExtends(AbstractTransactionSet::class);
        $class->addMethod('getId')->setBody("return 'ST';")->setReturnType('string');

        $segments = $this->transactionSet->getSegments();
        $stSegment = array_shift($segments);

        if (!($stSegment instanceof Segment) || $stSegment->getId() !== 'ST') {
            throw new \RuntimeException('Unexpected segment');
        }

        $this->registerElements($namespace, $class, $stSegment->getElements());
        $this->registerSegments($namespace, $class, $segments);

        file_put_contents($this->getFilename(), (string) $file);
    }
}
