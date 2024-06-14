<?php

namespace Gtlogistics\X12Parser\Model;

abstract class AbstractLoop implements LoopInterface
{
    use HasSegmentsTrait;

    public function __construct()
    {
    }

    public function __get(string $key): mixed
    {
        return $this->segments[$key];
    }

    public function __set(string $key, mixed $value): void
    {
        $this->segments[$key] = $value;
    }

    public function __isset(string $key): bool
    {
        return isset($this->segments[$key]);
    }
}