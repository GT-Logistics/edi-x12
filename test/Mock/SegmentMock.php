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

namespace Gtlogistics\EdiX12\Test\Mock;

use Gtlogistics\EdiX12\Model\AbstractSegment;

/**
 * @property mixed $_01
 * @property mixed $test_01
 */
class SegmentMock extends AbstractSegment
{
    /**
     * @param array<int, string> $castings
     */
    public function setCastings(array $castings): void
    {
        $this->castings = $castings;
    }

    /**
     * @param array<int, array{int, int}> $lengths
     */
    public function setLengths(array $lengths): void
    {
        $this->lengths = $lengths;
    }

    /**
     * @param array<int, true> $required
     */
    public function setRequired(array $required): void
    {
        $this->required = $required;
    }

    public function getId(): string
    {
        return 'TST';
    }
}
