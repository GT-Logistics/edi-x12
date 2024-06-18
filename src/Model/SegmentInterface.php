<?php

namespace Gtlogistics\X12Parser\Model;

interface SegmentInterface
{
    public function __construct();

    public function getId(): string;

    /**
     * @return string[]
     */
    public function getElements(): array;

    /**
     * @param string[] $elements
     */
    public function setElements(array $elements): void;
}
