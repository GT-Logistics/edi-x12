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

use Gtlogistics\EdiX12\Model\AbstractSegment;
use Gtlogistics\EdiX12\Schema\Segment;
use Laminas\Code\Generator\ClassGenerator;
use Laminas\Code\Generator\DocBlockGenerator;
use Laminas\Code\Generator\FileGenerator;
use Laminas\Code\Generator\MethodGenerator;

final readonly class SegmentClassGenerator extends AbstractClassGenerator
{
    use RegisterElementTrait;

    public function __construct(
        string $outputPath,
        string $namespace,
        private ClassMap $classMap,
        private Segment $segment,
    ) {
        parent::__construct($outputPath, $namespace, "{$segment->getId()}Segment");
    }

    public function getNamespace(): string
    {
        return parent::getNamespace() . '\\Segment';
    }

    public function getDirname(): string
    {
        return parent::getDirname() . DIRECTORY_SEPARATOR . 'Segment';
    }

    public function write(): void
    {
        $segmentId = $this->segment->getId();
        $this->classMap->addSegmentClass($segmentId, $this->getFullClassName());

        if (file_exists($this->getFilename())) {
            return;
        }

        $docblock = (new DocBlockGenerator())->setWordWrap(false);
        $class = new ClassGenerator($this->getClassName(), $this->getNamespace(), docBlock: $docblock);
        $file = (new FileGenerator())->setClass($class)->setFilename($this->getFilename());

        $class->setExtendedClass(AbstractSegment::class);

        $getIdMethod = new MethodGenerator('getId', body: "return '$segmentId';");
        $getIdMethod->setReturnType('string');
        $class->addMethodFromGenerator($getIdMethod);

        $elements = $this->segment->getElements();
        $this->registerElements($class, $docblock, $elements);

        $file->write();
    }
}
