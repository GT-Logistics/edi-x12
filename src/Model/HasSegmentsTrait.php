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
     * @var array<int, (SegmentInterface|LoopInterface)[]>
     */
    protected array $segments = [];

    public function getSegments(): array
    {
        $flatSegments = [];

        // Because the array could be a sparse array,
        // we need to order it first by its index order
        ksort($this->segments, SORT_NUMERIC);
        foreach ($this->segments as $segments) {
            foreach ($segments as $segment) {
                if ($segment instanceof LoopInterface) {
                    array_push($flatSegments, ...$segment->getSegments());
                } else {
                    $flatSegments[] = $segment;
                }
            }
        }

        return $flatSegments;
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
                    $index = $this->getOrder($currentLoop->getId());
                    // Register the segments and the loop itself
                    $currentLoop->setSegments($currentLoopSegments);

                    $this->segments[$index][] = $currentLoop;
                }

                $currentLoop = new $loopClass();
                $currentLoopSegments = [$segment];

                continue;
            }

            // If we're not on a loop, register the segment
            if (!$currentLoop) {
                $index = $this->getOrder($segment->getId());
                $this->segments[$index][] = $segment;

                continue;
            }

            $index = $this->getOrder($currentLoop->getId());

            $currentLoop->setSegments($currentLoopSegments);

            $this->segments[$index][] = $currentLoop;
            $currentLoop = null;
        }

        // If we ended, and we're still in a loop,
        if ($currentLoop) {
            $index = $this->getOrder($currentLoop->getId());
            // Register the segments and the loop itself
            $currentLoop->setSegments($currentLoopSegments);

            $this->segments[$index][] = $currentLoop;
        }
    }

    public function jsonSerialize(): array
    {
        $data = [];
        if (is_callable('parent::jsonSerialize')) {
            $data['*'] = parent::jsonSerialize();
        }

        $normalizedSegments = [];
        foreach (static::$order as $key => $index) {
            if (isset($this->segments[$index])) {
                $normalizedSegments[$key] = $this->segments[$index];
            }
        }

        return [
            ...$data,
            ...$normalizedSegments,
        ];
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
        $index = $this->getOrder($key);

        return isset($this->segments[$index]);
    }

    /**
     * @return SegmentInterface[]|LoopInterface[]
     */
    private function &getSegment(string $key): array
    {
        $index = $this->getOrder($key);

        $this->segments[$index] ??= [];

        return $this->segments[$index];
    }

    private function setSegment(string $key, mixed $value): void
    {
        $index = $this->getOrder($key);

        $this->segments[$index] = $this->validateSegments($key, $value);
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

    private function getOrder(string $key): int
    {
        return static::$order[$key] ?? throw new \InvalidArgumentException(sprintf('The segment "%s" is not supported.', $key));
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
