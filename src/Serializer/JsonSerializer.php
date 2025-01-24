<?php

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
            $serializedIsa = ['@' => $isa->getElements()];
            foreach ($isa->GS as $gs) {
                $serializedGs = ['@' => $gs->getElements()];
                foreach ($gs->ST as $st) {
                    $serializedSt = ['@' => $st->getElements()];
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
        $array[$segment->getId()][] = $segment->getElements();
    }
}
