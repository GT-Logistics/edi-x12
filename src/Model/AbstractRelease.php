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

abstract class AbstractRelease implements ReleaseInterface
{
    /**
     * @var array<string, class-string<TransactionSetInterface>>
     */
    protected array $transactionSetClassMap;

    /**
     * @var array<string, class-string<SegmentInterface>>
     */
    protected array $segmentClassMap;

    /**
     * @param array<string, class-string<TransactionSetInterface>>|null $transactionSetClassMap
     * @param array<string, class-string<SegmentInterface>>|null $segmentClassMap
     */
    public function __construct(
        ?array $transactionSetClassMap = null,
        ?array $segmentClassMap = null,
    ) {
        if ($transactionSetClassMap !== null) {
            $this->transactionSetClassMap = $transactionSetClassMap;
        }
        if ($segmentClassMap !== null) {
            $this->segmentClassMap = $segmentClassMap;
        }
    }

    public function makeTransactionSet(string $code): TransactionSetInterface
    {
        $class = $this->transactionSetClassMap[$code];

        return new $class();
    }

    /**
     * @param class-string<TransactionSetInterface> $transactionSetClass
     */
    public function addTransactionSetClass(string $code, string $transactionSetClass): void
    {
        $this->transactionSetClassMap[$code] = $transactionSetClass;
    }

    public function removeTransactionSetClass(string $code): void
    {
        unset($this->transactionSetClassMap[$code]);
    }

    public function makeSegment(string $id): SegmentInterface
    {
        $class = $this->segmentClassMap[$id];

        return new $class();
    }

    /**
     * @param class-string<SegmentInterface> $segmentClass
     */
    public function addSegmentClass(string $id, string $segmentClass): void
    {
        $this->segmentClassMap[$id] = $segmentClass;
    }

    public function removeSegmentClass(string $id): void
    {
        unset($this->segmentClassMap[$id]);
    }
}
