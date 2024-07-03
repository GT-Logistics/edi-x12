<?php

declare(strict_types=1);

namespace Gtlogistics\EdiX12\Model;

abstract class AbstractLoop implements LoopInterface
{
    use HasSegmentsTrait;

    public function __construct()
    {
    }

    public function &__get(string $key): mixed
    {
        return $this->getSegment($key);
    }

    public function __set(string $key, mixed $value): void
    {
        $this->setSegment($key, $value);
    }

    public function __isset(string $key): bool
    {
        return $this->hasSegment($key);
    }

    public static function isFirstSegment(SegmentInterface $segment): bool
    {
        return array_key_first(static::$order) === $segment->getId();
    }
}
