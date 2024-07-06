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

namespace Gtlogistics\EdiX12\Parser;

use Gtlogistics\EdiX12\Edi;
use Gtlogistics\EdiX12\Exception\MalformedX12Exception;
use Gtlogistics\EdiX12\Heading\GsHeading;
use Gtlogistics\EdiX12\Heading\IsaHeading;
use Gtlogistics\EdiX12\Model\ReleaseInterface;
use Gtlogistics\EdiX12\Model\TransactionSetInterface;

final readonly class X12Parser
{
    /**
     * @param ReleaseInterface[] $releases
     */
    public function __construct(private array $releases)
    {
    }

    public function parse(string $rawX12): Edi
    {
        $rawX12 = str_replace(["\n", "\t", "\r"], '', $rawX12);
        if (!str_starts_with($rawX12, 'ISA')) {
            throw new MalformedX12Exception('The first 3 bytes must be "ISA".');
        }

        $rawIsa = substr($rawX12, 0, 106);
        if (strlen($rawIsa) !== 106) {
            throw new MalformedX12Exception('The ISA Header must be 106 characters long.');
        }

        /** @var non-empty-string $elementDelimiter */
        $elementDelimiter = $rawIsa[3];
        /** @var non-empty-string $segmentDelimiter */
        $segmentDelimiter = $rawIsa[105];

        $elements = explode($elementDelimiter, $rawIsa);
        if (count($elements) !== 17) {
            throw new MalformedX12Exception('The ISA Header must be 17 elements long.');
        }

        $components = array_map(static fn (string $component) => explode($elementDelimiter, $component), explode($segmentDelimiter, $rawX12));

        return new Edi($this->parseInterchangeControls($components));
    }

    /**
     * @param string[][] $segments
     *
     * @return IsaHeading[]
     */
    private function parseInterchangeControls(array $segments): array
    {
        $isa = [];
        $currentIsa = null;
        $currentRelease = null;
        $currentSegments = [];
        $ended = true;

        foreach ($segments as $elements) {
            $segmentId = $elements[0];

            if ($segmentId === 'ISA') {
                if (!$ended) {
                    throw new MalformedX12Exception('The ISA header does not have the IEA trailer');
                }

                $currentIsa = new IsaHeading();
                $currentIsa->setElements($elements);
                $currentRelease = $this->getRelease($currentIsa->_12);
                $currentSegments = [];
                $ended = false;

                continue;
            }
            if ($segmentId === 'IEA') {
                if (!$currentIsa || !$currentRelease || $ended) {
                    throw new MalformedX12Exception('The IEA trailer does not have a matching ISA segment');
                }

                $gs = $this->parseFunctionalGroups($currentRelease, $currentSegments);

                if (count($gs) !== (int) $elements[1]) {
                    throw new MalformedX12Exception('The ISA header does not have the declared number of GS in the IEA trailer');
                }

                $currentIsa->GS = $gs;
                $isa[] = $currentIsa;
                $ended = true;

                continue;
            }

            $currentSegments[] = $elements;
        }

        if (!$ended) {
            throw new MalformedX12Exception('The ISA header does not have the termination IEA');
        }

        return $isa;
    }

    /**
     * @param string[][] $segments
     *
     * @return GsHeading[]
     */
    private function parseFunctionalGroups(ReleaseInterface $release, array $segments): array
    {
        $gs = [];
        $currentGs = null;
        $currentSegments = [];
        $ended = true;

        foreach ($segments as $elements) {
            $segmentId = $elements[0];

            if ($segmentId === 'GS') {
                if (!$ended) {
                    throw new MalformedX12Exception('The GS header does not have the GE trailer');
                }

                $currentGs = new GsHeading();
                $currentGs->setElements($elements);
                $currentSegments = [];
                $ended = false;

                continue;
            }
            if ($segmentId === 'GE') {
                if (!$currentGs || $ended) {
                    throw new MalformedX12Exception('The GE trailer does not have a matching GS segment');
                }

                $st = $this->parseTransactionSets($release, $currentSegments);

                if (count($st) !== (int) $elements[1]) {
                    throw new MalformedX12Exception('The GS header does not have the declared number of ST in the GE trailer');
                }

                $currentGs->ST = $st;
                $gs[] = $currentGs;
                $ended = true;

                continue;
            }

            $currentSegments[] = $elements;
        }

        if (!$ended) {
            throw new MalformedX12Exception('The GS header does not have the GE trailer');
        }

        return $gs;
    }

    /**
     * @param string[][] $segments
     *
     * @return TransactionSetInterface[]
     */
    private function parseTransactionSets(ReleaseInterface $release, array $segments): array
    {
        $st = [];
        $currentSt = null;
        $currentSegments = [];
        $segmentCount = 0;
        $ended = true;

        foreach ($segments as $elements) {
            $segmentId = $elements[0];

            if ($segmentId === 'ST') {
                if (!$ended) {
                    throw new MalformedX12Exception('The ST header does not have the SE trailer');
                }

                $transactionSetId = $elements[1];
                $currentSt = $release->makeTransactionSet($transactionSetId);
                $currentSt->setElements($elements);

                $currentSegments = [];
                $segmentCount = 0;
                $ended = false;

                continue;
            }
            if ($segmentId === 'SE') {
                if (!$currentSt || $ended) {
                    throw new MalformedX12Exception('The SE trailer does not have a matching ST segment');
                }

                // Must be the extracted number of segments plus 2 (for the excluded ST and SE segments)
                if ($segmentCount + 2 !== ((int) $elements[1])) {
                    throw new MalformedX12Exception('The ST header does not have the declared number of segments in the SE trailer');
                }

                $currentSt->setSegments($currentSegments);
                $st[] = $currentSt;
                $ended = true;

                continue;
            }

            $currentSegment = $release->makeSegment($segmentId);
            $currentSegment->setElements($elements);
            $currentSegments[] = $currentSegment;
            ++$segmentCount;
        }

        if (!$ended) {
            throw new MalformedX12Exception('The ST header does not have the SE trailer');
        }

        return $st;
    }

    private function getRelease(string $releaseId): ReleaseInterface
    {
        foreach ($this->releases as $release) {
            if ($release->supports($releaseId)) {
                return $release;
            }
        }

        throw new \RuntimeException("Could not found release $releaseId.");
    }
}
