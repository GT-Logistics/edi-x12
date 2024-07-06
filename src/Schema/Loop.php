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

namespace Gtlogistics\EdiX12\Schema;

final class Loop implements SegmentInterface
{
    /**
     * @var SegmentInterface[]
     */
    private array $segments = [];

    public function __construct(
        private readonly string $id,
        private int $min = -1,
        private int $max = -1,
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getMin(): int
    {
        return $this->min;
    }

    public function setMin(int $min): void
    {
        $this->min = $min;
    }

    public function getMax(): int
    {
        return $this->max;
    }

    public function setMax(int $max): void
    {
        $this->max = $max;
    }

    /**
     * @return SegmentInterface[]
     */
    public function getSegments(): array
    {
        return $this->segments;
    }

    public function addSegment(SegmentInterface $segment): void
    {
        $this->segments[] = $segment;
    }
}
