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

use Gtlogistics\EdiX12\Schema\Loop;
use Gtlogistics\EdiX12\Schema\Segment;
use Gtlogistics\EdiX12\Schema\SegmentInterface;
use Nette\PhpGenerator\ClassType;
use Nette\PhpGenerator\Literal;
use Nette\PhpGenerator\PhpNamespace;

trait RegisterSegmentTrait
{
    /**
     * @param SegmentInterface[] $segments
     */
    private function registerSegments(PhpNamespace $namespace, ClassType $class, array $segments): void
    {
        $order = [];
        $loops = [];
        foreach ($segments as $index => $segment) {
            $segmentClass = $this->registerSegment($namespace, $class, $segment);
            if ($segment instanceof Loop) {
                $firstSegment = $segment->getSegments()[0];

                $loops[$firstSegment->getId()] = new Literal($segmentClass . '::class');
            }

            $order[$segment->getId()] = $index;
        }

        if (count($loops) > 0) {
            $class->addProperty('loops', $loops)->setStatic()->setProtected()->setType('array');
        }
        if (count($order) > 0) {
            $class->addProperty('order', $order)->setStatic()->setProtected()->setType('array');
        }
    }

    private function registerSegment(PhpNamespace $namespace, ClassType $class, SegmentInterface $segment): string
    {
        $segmentId = $segment->getId();
        $generator = match (true) {
            $segment instanceof Loop => new LoopClassGenerator($this->getRootDirname(), $this->getRootNamespace(), $this->printer, $this->classMap, $this->transactionSet, $segment),
            $segment instanceof Segment => new SegmentClassGenerator($this->getRootDirname(), $this->getRootNamespace(), $this->printer, $this->classMap, $segment),
            default => throw new \RuntimeException('Unsupported segment ' . $segment->getId()),
        };

        $namespace->addUse($generator->getFullClassName());
        $class->addComment(sprintf('@property %s $%s', $generator->getClassName() . '[]', $segmentId));

        $generator->write();

        return $generator->getClassName();
    }
}
