<?php

namespace Gtlogistics\X12Parser\Parser;

use Gtlogistics\X12Parser\Edi;
use Gtlogistics\X12Parser\Exception\MalformedX12Exception;
use Gtlogistics\X12Parser\Heading\GsHeading;
use Gtlogistics\X12Parser\Heading\IsaHeading;
use Gtlogistics\X12Parser\Model\ReleaseInterface;
use Gtlogistics\X12Parser\Model\TransactionSetInterface;

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
                if (!$currentIsa || !$currentRelease) {
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
                if (!$currentGs) {
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
                $transactionSetClass = $release->getTransactionSetClass($transactionSetId);
                $currentSt = new $transactionSetClass();
                $currentSt->setElements($elements);

                $currentSegments = [];
                $segmentCount = 0;
                $ended = false;

                continue;
            }
            if ($segmentId === 'SE') {
                if (!$currentSt) {
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

            $segmentClass = $release->getSegmentClass($segmentId);
            $currentSegment = new $segmentClass();
            $currentSegment->setElements($elements);
            $currentSegments[] = $currentSegment;
            $segmentCount++;
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
