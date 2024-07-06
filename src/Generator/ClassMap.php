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

use Gtlogistics\EdiX12\Model\SegmentInterface;
use Gtlogistics\EdiX12\Model\TransactionSetInterface;

final class ClassMap
{
    /**
     * @var array<string, class-string<TransactionSetInterface>>
     */
    private array $transactionSetClassMap = [];

    /**
     * @var array<string, class-string<SegmentInterface>>
     */
    private array $segmentClassMap = [];

    /**
     * @return array<string, class-string<TransactionSetInterface>>
     */
    public function getTransactionSetClassMap(): array
    {
        return $this->transactionSetClassMap;
    }

    /**
     * @param class-string<TransactionSetInterface> $transactionSetClass
     */
    public function addTransactionSetClass(string $code, string $transactionSetClass): void
    {
        $this->transactionSetClassMap[$code] = $transactionSetClass;
    }

    /**
     * @return array<string, class-string<SegmentInterface>>
     */
    public function getSegmentClassMap(): array
    {
        return $this->segmentClassMap;
    }

    /**
     * @param class-string<SegmentInterface> $segmentClass
     */
    public function addSegmentClass(string $id, string $segmentClass): void
    {
        $this->segmentClassMap[$id] = $segmentClass;
    }
}
