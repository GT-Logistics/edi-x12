<?php

declare(strict_types=1);

namespace Gtlogistics\EdiX12\Model;

interface WithSegmentsInterface
{
    /**
     * @return SegmentInterface[]
     */
    public function getSegments(): array;

    /**
     * @param SegmentInterface[] $segments
     */
    public function setSegments(array $segments): void;
}
