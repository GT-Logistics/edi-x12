<?php

namespace Gtlogistics\X12Parser\Schema;

final class Loop implements SegmentInterface
{
    /**
     * @var Segment[]
     */
    private array $segments = [];

    public function __construct(
        private readonly string $id,
        private int $min = -1,
        private int $max = -1,
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getMin(): int
    {
        return $this->min;
    }

    public function setMin(int $min): void
    {
        $this->min = $min;
    }

    public function getMax(): int
    {
        return $this->max;
    }

    public function setMax(int $max): void
    {
        $this->max = $max;
    }

    /**
     * @return Segment[]
     */
    public function getSegments(): array
    {
        return $this->segments;
    }

    public function addSegment(SegmentInterface $segment): void
    {
        $this->segments[] = $segment;
    }
}