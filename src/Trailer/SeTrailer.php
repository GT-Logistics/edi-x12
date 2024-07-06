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

namespace Gtlogistics\EdiX12\Trailer;

use Gtlogistics\EdiX12\Model\AbstractSegment;

/**
 * @property int $numberOfIncludedSegments_01 **Number of Included Segments:** Total number of segments included in a transaction set including ST and SE segments
 * @property int $_01 See $numberOfIncludedSegments_01
 * @property string $transactionSetControlNumber_02 **Transaction Set Control Number:** Identifying control number that must be unique within the transaction set functional group assigned by the originator for a transaction set
 * @property string $_02 See $transactionSetControlNumber_02
 */
final class SeTrailer extends AbstractSegment
{
    protected array $castings = [
        1 => 'int',
    ];

    protected array $lengths = [
        1 => [1, 10],
        2 => [4, 9],
    ];

    protected array $required = [
        1 => true,
        2 => true,
    ];

    public function getId(): string
    {
        return 'SE';
    }
}
