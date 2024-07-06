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
 * @property int $numberOfIncludedFunctionalGroups_01 **Number of Included Functional Groups:** A count of the number of functional groups included in an interchange
 * @property int $_01 See $numberOfIncludedFunctionalGroups_01
 * @property int $interchangeControlNumber_02 **Interchange Control Number:** A control number assigned by the interchange sender
 * @property int $_02 See $interchangeControlNumber_02
 */
final class IeaTrailer extends AbstractSegment
{
    protected array $castings = [
        1 => 'int',
        2 => 'int',
    ];

    protected array $lengths = [
        1 => [1, 5],
        2 => [9, 9],
    ];

    protected array $required = [
        1 => true,
        2 => true,
    ];

    public function getId(): string
    {
        return 'IEA';
    }
}
