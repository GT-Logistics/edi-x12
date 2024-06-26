<?php

declare(strict_types=1);

namespace Gtlogistics\X12Parser\Schema;

interface SegmentInterface
{
    public function getId(): string;

    public function getMin(): int;

    public function getMax(): int;
}
