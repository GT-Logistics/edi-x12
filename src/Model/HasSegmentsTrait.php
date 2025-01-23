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

namespace Gtlogistics\EdiX12\Model;

use Webmozart\Assert\Assert;

trait HasSegmentsTrait
{
    /**
     * @var array<string, int>
     */
    protected static array $order = [];

    /**
     * @var array<string, class-string<LoopInterface>>
     */
    protected static array $loops = [];

    /**
     * @var array<string, SegmentInterface[]|LoopInterface[]>
     */
    protected array $segments = [];

    public function getSegments(): iterable
    {
        // Because the array could be a sparse array,
        // we need to order it first by its index order
        foreach (static::$order as $id => $_) {
            if (!isset($this->segments[$id])) {
                continue;
            }

            foreach ($this->segments[$id] as $segment) {
                yield $segment;
            }
        }
    }

    public function setSegments(array $segments): void
    {
        $this->segments = [];

        $currentLoop = null;
        $currentLoopSegments = [];
        foreach ($segments as $segment) {
            // Collect the segments that are part of the loop
            if ($currentLoop && !$currentLoop::isFirstSegment($segment) && $currentLoop::supportSegment($segment)) {
                $currentLoopSegments[] = $segment;

                continue;
            }

            // If the segment is the start of the loop, begin the loop
            if ($loopClass = static::$loops[$segment->getId()] ?? null) {
                // If we're on a loop...
                if ($currentLoop) {
                    // Register the segments and the loop itself
                    $currentLoop->setSegments($currentLoopSegments);

                    $this->segments[$currentLoop->getId()][] = $currentLoop;
                }

                $currentLoop = new $loopClass();
                $currentLoopSegments = [$segment];

                continue;
            }

            // If we're not on a loop, register the segment
            if (!$currentLoop) {
                $this->segments[$segment->getId()][] = $segment;

                continue;
            }

            $currentLoop->setSegments($currentLoopSegments);

            $this->segments[$currentLoop->getId()][] = $currentLoop;
            $this->segments[$segment->getId()][] = $segment;
            $currentLoop = null;
        }

        // If we ended, and we're still in a loop,
        if ($currentLoop) {
            // Register the segments and the loop itself
            $currentLoop->setSegments($currentLoopSegments);

            $this->segments[$currentLoop->getId()][] = $currentLoop;
        }
    }

    public function __serialize(): array
    {
        $data = [];
        if (is_callable('parent::__serialize')) {
            $data = parent::__serialize();
        }

        return [
            ...$data,
            'segments' => $this->segments,
        ];
    }

    private function hasSegment(string $key): bool
    {
        return isset($this->segments[$key]);
    }

    /**
     * @return SegmentInterface[]|LoopInterface[]
     */
    private function &getSegment(string $key): array
    {
        $this->segments[$key] ??= [];

        return $this->segments[$key];
    }

    private function setSegment(string $key, mixed $value): void
    {
        $this->segments[$key] = $this->validateSegments($key, $value);
    }

    public static function supportSegment(SegmentInterface $segment): bool
    {
        if (isset(static::$order[$segment->getId()])) {
            return true;
        }

        foreach (static::$loops as $loop) {
            if ($loop::supportSegment($segment)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return (SegmentInterface|LoopInterface)[]
     */
    private function validateSegments(string $key, mixed $value): array
    {
        $result = [];

        Assert::isArray($value);
        foreach ($value as $item) {
            Assert::isInstanceOfAny($item, [LoopInterface::class, SegmentInterface::class]);
            Assert::same($item->getId(), $key);

            $result[] = $item;
        }

        return $result;
    }
}
