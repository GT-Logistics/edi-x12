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
use Gtlogistics\EdiX12\Model\LoopInterface;
use Gtlogistics\EdiX12\Model\SegmentInterface;
use Gtlogistics\EdiX12\Model\WithSegmentsInterface;
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
            $this->pushSegment($serializedSegments, $isa);
            foreach ($isa->GS as $gs) {
                $this->pushSegment($serializedSegments, $gs);
                foreach ($gs->ST as $st) {
                    $this->pushSegment($serializedSegments, $st);
                    $this->pushNested($serializedSegments, $st);
                    $this->pushSegment($serializedSegments, $this->ediUtils->seTrailer($st));
                }
                $this->pushSegment($serializedSegments, $this->ediUtils->geTrailer($gs));
            }
            $this->pushSegment($serializedSegments, $this->ediUtils->ieaTrailer($isa));
        }

        return implode("$this->segmentDelimiter\n", $serializedSegments);
    }

    /**
     * @param string[] $array
     */
    private function pushNested(array &$array, WithSegmentsInterface $nested): void
    {
        foreach ($nested->getSegments() as $segment) {
            if ($segment instanceof LoopInterface) {
                $this->pushNested($array, $segment);

                continue;
            }

            $this->pushSegment($array, $segment);
        }
    }

    /**
     * @param string[] $array
     */
    private function pushSegment(array &$array, SegmentInterface $segment): void
    {
        $array[] = rtrim(implode($this->elementDelimiter, $segment->getElements()), $this->elementDelimiter);
    }
}
