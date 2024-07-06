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

namespace Gtlogistics\EdiX12\Serializer;

use Gtlogistics\EdiX12\Edi;
use Gtlogistics\EdiX12\Model\SegmentInterface;
use Gtlogistics\EdiX12\Trailer\GeTrailer;
use Gtlogistics\EdiX12\Trailer\IeaTrailer;
use Gtlogistics\EdiX12\Trailer\SeTrailer;

final readonly class X12Serializer
{
    public function __construct(
        private string $elementDelimiter,
        private string $segmentDelimiter,
    ) {
    }

    public function serialize(Edi $edi): string
    {
        $serializedSegments = [];
        foreach ($edi->ISA as $isa) {
            $iea = new IeaTrailer();
            $iea->numberOfIncludedFunctionalGroups_01 = count($isa->GS);
            $iea->interchangeControlNumber_02 = $isa->interchangeControlNumber_13;

            $serializedSegments[] = $this->serializeSegment($isa);
            foreach ($isa->GS as $gs) {
                $ge = new GeTrailer();
                $ge->numberOfTransactionSetsIncluded_01 = count($gs->ST);
                $ge->groupControlNumber_02 = $gs->groupControlNumber_06;

                $serializedSegments[] = $this->serializeSegment($gs);
                foreach ($gs->ST as $st) {
                    $segments = $st->getSegments();
                    $elements = $st->getElements();

                    $se = new SeTrailer();
                    // Must be the number of segments plus 2 (for the excluded ST and SE segments)
                    $se->numberOfIncludedSegments_01 = count($segments) + 2;
                    $se->transactionSetControlNumber_02 = $elements[2];

                    $serializedSegments[] = $this->serializeSegment($st);
                    foreach ($segments as $segment) {
                        $serializedSegments[] = $this->serializeSegment($segment);
                    }
                    $serializedSegments[] = $this->serializeSegment($se);
                }
                $serializedSegments[] = $this->serializeSegment($ge);
            }
            $serializedSegments[] = $this->serializeSegment($iea);
        }

        return implode("$this->segmentDelimiter\n", $serializedSegments);
    }

    private function serializeSegment(SegmentInterface $segment): string
    {
        return rtrim(implode($this->elementDelimiter, $segment->getElements()), $this->elementDelimiter);
    }
}
