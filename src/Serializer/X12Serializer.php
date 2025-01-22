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
use Gtlogistics\EdiX12\Util\EdiUtils;

final readonly class X12Serializer implements SerializerInterface
{
    private EdiUtils $ediUtils;

    public function __construct(
        private string $elementDelimiter,
        private string $segmentDelimiter,
    ) {
        $this->ediUtils = new EdiUtils();
    }

    public function serialize(Edi $edi): string
    {
        $serializedSegments = [];

        foreach ($edi->ISA as $isa) {
            $serializedSegments[] = $this->serializeSegment($isa);
            foreach ($isa->GS as $gs) {
                $serializedSegments[] = $this->serializeSegment($gs);
                foreach ($gs->ST as $st) {
                    $serializedSegments[] = $this->serializeSegment($st);
                    foreach ($st->getSegments() as $segment) {
                        $serializedSegments[] = $this->serializeSegment($segment);
                    }
                    $serializedSegments[] = $this->serializeSegment($this->ediUtils->seTrailer($st));
                }
                $serializedSegments[] = $this->serializeSegment($this->ediUtils->geTrailer($gs));
            }
            $serializedSegments[] = $this->serializeSegment($this->ediUtils->ieaTrailer($isa));
        }

        return implode("$this->segmentDelimiter\n", $serializedSegments);
    }

    private function serializeSegment(SegmentInterface $segment): string
    {
        return rtrim(implode($this->elementDelimiter, $segment->getElements()), $this->elementDelimiter);
    }
}
