<?php

namespace Gtlogistics\X12Parser\Model;

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
