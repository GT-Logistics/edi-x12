<?php

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
        $elements = $st->getElements();

        $se = new SeTrailer();
        // Must be the number of segments plus 2 (for the excluded ST and SE segments)
        $se->numberOfIncludedSegments_01 = $st->countSegments() + 2;
        $se->transactionSetControlNumber_02 = $elements[2];

        return $se;
    }
}
