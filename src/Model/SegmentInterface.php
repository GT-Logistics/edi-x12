<?php

declare(strict_types=1);

namespace Gtlogistics\X12Parser\Model;

interface SegmentInterface
{
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
