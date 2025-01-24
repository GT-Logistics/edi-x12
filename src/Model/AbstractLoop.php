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

abstract class AbstractLoop implements LoopInterface
{
    use HasSegmentsTrait;

    public function __construct()
    {
    }

    public function &__get(string $key): mixed
    {
        return $this->getSegment($key);
    }

    public function __set(string $key, mixed $value): void
    {
        $this->setSegment($key, $value);
    }

    public function __isset(string $key): bool
    {
        return $this->hasSegment($key);
    }

    public static function isFirstSegment(SegmentInterface $segment): bool
    {
        return array_key_first(static::$order) === $segment->getId();
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
}
