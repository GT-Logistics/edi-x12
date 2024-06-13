<?php

namespace Gtlogistics\X12Parser\Model;

interface TransactionSetInterface extends SegmentInterface
{
    /**
     * @return (SegmentInterface|LoopInterface)[]
     */
    public function getSegments(): array;

    /**
     * @param (SegmentInterface|LoopInterface)[] $segments
     */
    public function setSegments(array $segments): void;
}
