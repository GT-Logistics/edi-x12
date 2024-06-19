<?php

namespace Gtlogistics\X12Parser\Model;

use Webmozart\Assert\Assert;

trait HasSegmentsTrait
{
    /**
     * @var array<string, int>
     */
    protected static array $order = [];

    /**
     * @var array<string, class-string<LoopInterface>>
     */
    protected static array $loops = [];

    /**
     * @var array<int, (SegmentInterface|LoopInterface)[]>
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
            // Collect the segments that are part of the loop
            if ($currentLoop && !$currentLoop::isFirstSegment($segment) && $currentLoop::supportSegment($segment)) {
                $currentLoopSegments[] = $segment;

                continue;
            }

            // If the segment is the start of the loop, begin the loop
            if ($loopClass = static::$loops[$segment->getId()] ?? null) {
                // If we're on a loop...
                if ($currentLoop) {
                    // Register the segments and the loop itself
                    $currentLoop->setSegments($currentLoopSegments);

                    $this->segments[$currentLoop->getId()][] = $currentLoop;
                }

                $currentLoop = new $loopClass();
                $currentLoopSegments = [$segment];

                continue;
            }

            // If we're not on a loop, register the segment
            if (!$currentLoop) {
                $this->segments[$segment->getId()][] = $segment;

                continue;
            }

            // Register the segments and the loop itself
            $currentLoop->setSegments($currentLoopSegments);

            $this->segments[$currentLoop->getId()][] = $currentLoop;
            $currentLoop = null;
        }

        // If we ended, and we're still in a loop,
        // register it with its segments
        if ($currentLoop) {
            $currentLoop->setSegments($currentLoopSegments);

            $this->segments[$currentLoop->getId()][] = $currentLoop;
        }
    }

    public static function supportSegment(SegmentInterface $segment): bool
    {
        if (isset(static::$order[$segment->getId()])) {
            return true;
        }

        foreach (static::$loops as $loop) {
            if ($loop::supportSegment($segment)) {
                return true;
            }
        }

        return false;
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
