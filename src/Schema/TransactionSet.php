<?php

namespace Gtlogistics\X12Parser\Schema;

final class TransactionSet
{
    /**
     * @var SegmentInterface[]
     */
    private array $segments;

    public function __construct(
        private readonly string $id
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return SegmentInterface[]
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
