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

use Gtlogistics\EdiX12\Model\AbstractRelease;
use Gtlogistics\EdiX12\Schema\Release;
use Nette\PhpGenerator\Literal;
use Nette\PhpGenerator\Parameter;
use Nette\PhpGenerator\PhpFile;
use Nette\PhpGenerator\Printer;

use function Safe\file_put_contents;

final readonly class ReleaseGenerator extends AbstractClassGenerator
{
    public function __construct(
        string $outputPath,
        string $namespace,
        private Printer $printer,
        private Release $release,
    ) {
        parent::__construct($outputPath, $namespace, "Release{$release->getId()}");
    }

    public function write(): void
    {
        $this->assureDirExists();

        $file = new PhpFile();
        $namespace = $file->addNamespace($this->getNamespace());
        $class = $namespace->addClass($this->getClassName());

        $classMap = new ClassMap();
        foreach ($this->release->getTransactionSets() as $transactionSet) {
            $transactionSetGenerator = new TransactionSetClassGenerator($this->getRootDirname(), $this->getRootNamespace(), $this->printer, $classMap, $transactionSet);

            $transactionSetGenerator->write();
        }

        $class->setExtends(AbstractRelease::class);
        $class->addProperty('transactionSetClassMap', $this->literalizeClasses($classMap->getTransactionSetClassMap()))
            ->setProtected()
            ->setType('array')
        ;
        $class->addProperty('segmentClassMap', $this->literalizeClasses($classMap->getSegmentClassMap()))
            ->setProtected()
            ->setType('array')
        ;

        $class->addMethod('supports')
            ->setParameters([(new Parameter('releaseId'))->setType('string')])
            ->setBody("return \$releaseId === '{$this->release->getId()}';")
            ->setReturnType('bool')
        ;

        file_put_contents($this->getFilename(), $this->printer->printFile($file));
    }

    /**
     * @template TKey of array-key
     *
     * @param array<TKey, class-string> $classes
     *
     * @return array<TKey, Literal>
     */
    private function literalizeClasses(array $classes): array
    {
        return array_map(static fn (string $class) => new Literal('\\' . $class . '::class'), $classes);
    }
}
