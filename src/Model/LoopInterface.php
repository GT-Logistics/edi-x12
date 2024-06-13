<?php

namespace Gtlogistics\X12Parser\Model;

interface LoopInterface
{
    public function __construct();

    /**
     * @return (SegmentInterface|LoopInterface)[]
     */
    public function getSegments(): array;

    /**
     * @param (SegmentInterface|LoopInterface)[] $segments
     */
    public function setSegments(array $segments): void;
}
