<?php

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

namespace Gtlogistics\EdiX12\Util;

use Gtlogistics\EdiX12\Heading\GsHeading;
use Gtlogistics\EdiX12\Heading\IsaHeading;
use Gtlogistics\EdiX12\Model\TransactionSetInterface;
use Gtlogistics\EdiX12\Trailer\GeTrailer;
use Gtlogistics\EdiX12\Trailer\IeaTrailer;
use Gtlogistics\EdiX12\Trailer\SeTrailer;

/**
 * @internal
 */
final class EdiUtils
{
    public function ieaTrailer(IsaHeading $isa): IeaTrailer
    {
        $iea = new IeaTrailer();
        $iea->numberOfIncludedFunctionalGroups_01 = count($isa->GS);
        $iea->interchangeControlNumber_02 = $isa->interchangeControlNumber_13;

        return $iea;
    }

    public function geTrailer(GsHeading $gs): GeTrailer
    {
        $ge = new GeTrailer();
        $ge->numberOfTransactionSetsIncluded_01 = count($gs->ST);
        $ge->groupControlNumber_02 = $gs->groupControlNumber_06;

        return $ge;
    }

    public function seTrailer(TransactionSetInterface $st): SeTrailer
    {
        $se = new SeTrailer();
        // Must be the number of segments plus 2 (for the excluded ST and SE segments)
        $se->numberOfIncludedSegments_01 = $st->countSegments() + 2;
        $se->transactionSetControlNumber_02 = $st->getTransactionSetControlNumber();

        return $se;
    }
}
