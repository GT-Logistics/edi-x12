<?php

namespace Gtlogistics\X12Parser\Model;

interface SegmentInterface
{
    public function __construct();

    /**
     * @return mixed[]
     */
    public function getElements(): array;

    /**
     * @param mixed[] $elements
     */
    public function setElements(array $elements): void;
}
