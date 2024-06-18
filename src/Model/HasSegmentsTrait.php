<?php

namespace Gtlogistics\X12Parser\Model;

use Webmozart\Assert\Assert;

trait HasSegmentsTrait
{
    /**
     * @var array<string, class-string<LoopInterface>>
     */
    protected array $loops = [];

    /**
     * @var array<string, (SegmentInterface|LoopInterface)[]>
     */
    protected array $segments = [];

    public function getSegments(): array
    {
        $flatSegments = [];

        foreach ($this->segments as $segments) {
            foreach ($segments as $segment) {
                if ($segment instanceof LoopInterface) {
                    array_push($flatSegments, ...$segment->getSegments());
                } else {
                    $flatSegments[] = $segment;
                }
            }
        }

        return $flatSegments;
    }

    public function setSegments(array $segments): void
    {
        $this->segments = [];
        $currentLoop = null;
        $currentLoopSegments = [];

        foreach ($segments as $segment) {
            // If the segment is the start of the loop, begin the loop
            if ($loopClass = $this->loops[$segment->getId()] ?? null) {
                $currentLoop = new $loopClass();
                $currentLoopSegments = [];

                continue;
            }

            // If we're on a loop
            if ($currentLoop) {
                // Collect the segments that are part of the loop
                if ($currentLoop->isPartOf($segment)) {
                    $currentLoopSegments[] = $segment;

                    continue;
                }

                // Register the segments and the loop itself
                $currentLoop->setSegments($currentLoopSegments);

                $this->segments[$currentLoop->getId()][] = $currentLoop;
                $currentLoop = null;
            }

            $this->segments[$segment->getId()][] = $segment;
        }
    }

    /**
     * @return (SegmentInterface|LoopInterface)[]
     */
    private function validateSegments(string $key, mixed $value): array
    {
        $result = [];

        Assert::isArray($value);
        foreach ($value as $item) {
            Assert::isInstanceOfAny($item, [LoopInterface::class, SegmentInterface::class]);
            Assert::same($item->getId(), $key);

            $result[] = $item;
        }

        return $result;
    }
}
