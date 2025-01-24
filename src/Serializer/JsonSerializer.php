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

namespace Gtlogistics\EdiX12\Serializer;

use Gtlogistics\EdiX12\Edi;
use Gtlogistics\EdiX12\Model\LoopInterface;
use Gtlogistics\EdiX12\Model\SegmentInterface;
use Gtlogistics\EdiX12\Model\WithSegmentsInterface;

use function Safe\json_encode;

final class JsonSerializer implements SerializerInterface
{
    public function __construct(
        private readonly int $jsonFlags = 0,
    ) {
    }

    public function serialize(Edi $edi): string
    {
        $serializedSegments = [];

        foreach ($edi->ISA as $isa) {
            $serializedIsa = ['@' => iterator_to_array($isa->getElements())];
            foreach ($isa->GS as $gs) {
                $serializedGs = ['@' => iterator_to_array($gs->getElements())];
                foreach ($gs->ST as $st) {
                    $serializedSt = ['@' => iterator_to_array($st->getElements())];
                    $this->pushNested($serializedSt, $st);
                    $serializedGs[$st->getId()][] = $serializedSt;
                }
                $serializedIsa[$gs->getId()][] = $serializedGs;
            }
            $serializedSegments[$isa->getId()][] = $serializedIsa;
        }

        return json_encode($serializedSegments, $this->jsonFlags | JSON_THROW_ON_ERROR);
    }

    /**
     * @param array<string, mixed[]> $array
     */
    private function pushNested(array &$array, WithSegmentsInterface $nested): void
    {
        foreach ($nested->getSegments() as $segment) {
            if ($segment instanceof LoopInterface) {
                $this->pushLoop($array, $segment);

                continue;
            }

            $this->pushSegment($array, $segment);
        }
    }

    /**
     * @param array<string, mixed[]> $array
     */
    private function pushLoop(array &$array, LoopInterface $loop): void
    {
        $serializedLoop = [];

        $this->pushNested($serializedLoop, $loop);
        $array[$loop->getId()][] = $serializedLoop;
    }

    /**
     * @param array<string, mixed[]> $array
     */
    private function pushSegment(array &$array, SegmentInterface $segment): void
    {
        $array[$segment->getId()][] = iterator_to_array($segment->getElements());
    }
}
