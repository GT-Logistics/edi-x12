<?php

namespace Gtlogistics\X12Parser\Parser;

use Gtlogistics\X12Parser\Edi;
use Gtlogistics\X12Parser\Exception\MalformedX12Exception;
use Gtlogistics\X12Parser\Heading\GsHeading;
use Gtlogistics\X12Parser\Heading\IsaHeading;
use Gtlogistics\X12Parser\Model\ReleaseInterface;
use Gtlogistics\X12Parser\Model\Segment;

final readonly class X12Parser
{
    /**
     * @param array<string, ReleaseInterface> $releases
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

        $elementDelimiter = $rawIsa[3];
        $segmentDelimiter = $rawIsa[105];

        $elements = explode($elementDelimiter, $rawIsa);
        if (count($elements) !== 17) {
            throw new MalformedX12Exception('The ISA Header must be 17 elements long.');
        }

        $components = array_map(static fn (string $component) => explode($elementDelimiter, $component), explode($segmentDelimiter, $rawX12));

        return new Edi($this->parseInterchangeControls($components));
    }

    private function parseInterchangeControls(array $segments): array
    {
        $isa = [];
        $currentIsa = null;
        $currentSegments = [];
        $ended = true;

        foreach ($segments as $elements) {
            $segmentId = $elements[0];

            if ($segmentId === 'ISA') {
                if (!$ended) {
                    throw new MalformedX12Exception('The ISA header does not have the IEA trailer');
                }

                $currentIsa = new IsaHeading($elements);
                $currentSegments = [];
                $ended = false;

                continue;
            }
            if ($segmentId === 'IEA') {
                $gs = $this->parseFunctionalGroups($currentSegments);

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

    private function parseFunctionalGroups(array $segments): array
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

                $currentGs = new GsHeading($elements);
                $currentSegments = [];
                $ended = false;

                continue;
            }
            if ($segmentId === 'GE') {
                $st = $this->parseTransactionSets($currentSegments);

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

    private function parseTransactionSets(array $segments): array
    {
        $st = [];
        $currentSt = null;
        $currentSegments = [];
        $ended = true;

        foreach ($segments as $elements) {
            $segmentId = $elements[0];

            if ($segmentId === 'ST') {
                if (!$ended) {
                    throw new MalformedX12Exception('The ST header does not have the SE trailer');
                }

                $currentSt = new Segment($elements);
                $currentSegments = [];
                $ended = false;

                continue;
            }
            if ($segmentId === 'SE') {
                // Must be the extracted number of segments plus 2 (for the excluded ST and SE segments)
                if (count($currentSegments) + 2 !== ((int) $elements[1])) {
                    throw new MalformedX12Exception('The ST header does not have the declared number of segments in the SE trailer');
                }

                $currentSt->segments = $currentSegments;
                $st[] = $currentSt;
                $ended = true;

                continue;
            }

            $currentSegments[] = $elements;
        }

        if (!$ended) {
            throw new MalformedX12Exception('The GS header does not have the GE trailer');
        }

        return $st;
    }

    private function getRelease(string $releaseId): ReleaseInterface
    {
        return $this->releases[$releaseId] ?? throw new \RuntimeException("Could not found release $releaseId.");
    }
}
