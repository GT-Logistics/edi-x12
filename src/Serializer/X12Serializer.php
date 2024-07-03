<?php

declare(strict_types=1);

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
            $iea->numberOfIncludedFunctionalGroups = count($isa->GS);
            $iea->interchangeControlNumber = $isa->interchangeControlNumber;

            $serializedSegments[] = $this->serializeSegment($isa);
            foreach ($isa->GS as $gs) {
                $ge = new GeTrailer();
                $ge->numberOfTransactionSetsIncluded = count($gs->ST);
                $ge->groupControlNumber = $gs->groupControlNumber;

                $serializedSegments[] = $this->serializeSegment($gs);
                foreach ($gs->ST as $st) {
                    $segments = $st->getSegments();
                    $elements = $st->getElements();

                    $se = new SeTrailer();
                    // Must be the number of segments plus 2 (for the excluded ST and SE segments)
                    $se->numberOfIncludedSegments = count($segments) + 2;
                    $se->transactionSetControlNumber = $elements[2];

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
