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

abstract class AbstractTransactionSet extends AbstractSegment implements TransactionSetInterface
{
    use HasSegmentsTrait;

    public function getTransactionSetControlNumber(): string
    {
        return $this->__get('_02');
    }

    public function &__get(string $key): mixed
    {
        if ($this->isElement($key)) {
            // We need a temporal variable
            // to pass by reference the value
            $_ = parent::__get($key);

            return $_;
        }

        return $this->getSegment($key);
    }

    public function __set(string $key, mixed $value): void
    {
        if ($this->isElement($key)) {
            parent::__set($key, $value);

            return;
        }

        $this->setSegment($key, $value);
    }

    public function __isset(string $key): bool
    {
        if ($this->isElement($key)) {
            return parent::__isset($key);
        }

        return $this->hasSegment($key);
    }

    private function isElement(string $key): bool
    {
        return str_starts_with(substr($key, -3, 3), '_');
    }
}
