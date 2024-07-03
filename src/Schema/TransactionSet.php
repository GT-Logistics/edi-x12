<?php

declare(strict_types=1);

namespace Gtlogistics\EdiX12\Schema;

final class TransactionSet
{
    /**
     * @var SegmentInterface[]
     */
    private array $segments;

    public function __construct(
        private readonly string $code,
    ) {
    }

    public function getCode(): string
    {
        return $this->code;
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
