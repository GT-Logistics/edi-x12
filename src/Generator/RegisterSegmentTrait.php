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
use Laminas\Code\Generator\AbstractMemberGenerator;
use Laminas\Code\Generator\ClassGenerator;
use Laminas\Code\Generator\DocBlock\Tag\PropertyTag;
use Laminas\Code\Generator\DocBlockGenerator;
use Laminas\Code\Generator\PropertyGenerator;
use Laminas\Code\Generator\TypeGenerator;

trait RegisterSegmentTrait
{
    /**
     * @param SegmentInterface[] $segments
     */
    private function registerSegments(ClassGenerator $class, DocBlockGenerator $docBlock, array $segments): void
    {
        $order = [];
        $loops = [];
        foreach ($segments as $index => $segment) {
            $segmentClass = $this->registerSegment($class, $docBlock, $segment);
            if ($segment instanceof Loop) {
                $firstSegment = $segment->getSegments()[0];

                $loops[$firstSegment->getId()] = $segmentClass;
            }

            $order[$segment->getId()] = $index;
        }

        if (count($loops) > 0) {
            $loopsProperty = new PropertyGenerator('loops', $loops, AbstractMemberGenerator::FLAG_STATIC | AbstractMemberGenerator::FLAG_PROTECTED, TypeGenerator::fromTypeString('array'));
            $class->addPropertyFromGenerator($loopsProperty);
        }
        if (count($order) > 0) {
            $orderProperty = new PropertyGenerator('order', $order, AbstractMemberGenerator::FLAG_STATIC | AbstractMemberGenerator::FLAG_PROTECTED, TypeGenerator::fromTypeString('array'));
            $class->addPropertyFromGenerator($orderProperty);
        }
    }

    private function registerSegment(ClassGenerator $class, DocBlockGenerator $docBlock, SegmentInterface $segment): string
    {
        $segmentId = $segment->getId();
        $generator = match (true) {
            $segment instanceof Loop => new LoopClassGenerator($this->getRootDirname(), $this->getRootNamespace(), $this->classMap, $this->transactionSet, $segment),
            $segment instanceof Segment => new SegmentClassGenerator($this->getRootDirname(), $this->getRootNamespace(), $this->classMap, $segment),
            default => throw new \RuntimeException('Unsupported segment ' . $segment->getId()),
        };

        $class->addUse($generator->getFullClassName());
        $docBlock->setTag(new PropertyTag($segmentId, [$generator->getClassName() . '[]']));

        $generator->write();

        return $generator->getFullClassName();
    }
}
