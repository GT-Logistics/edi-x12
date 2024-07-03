<?php

declare(strict_types=1);

namespace Gtlogistics\EdiX12\Model;

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
