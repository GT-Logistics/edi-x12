<?php

namespace Gtlogistics\X12Parser\Model;

abstract class AbstractTransactionSet extends AbstractSegment implements TransactionSetInterface
{
    use HasSegmentsTrait;

    public function __get(string $key): mixed
    {
        if ($this->isElement($key)) {
            return parent::__get($key);
        }

        return array_values(array_filter($this->segments, static fn (SegmentInterface|LoopInterface $segment) => $segment->getId() === $key));
    }

    public function __set(string $key, mixed $value): void
    {
        if ($this->isElement($key)) {
            parent::__set($key, $value);

            return;
        }

        $this->segments[] = $value;
    }

    public function __isset(string $key): bool
    {
        if ($this->isElement($key)) {
            return parent::__isset($key);
        }

        return isset($this->segments[$key]);
    }

    private function isElement(string $key): int
    {
        return str_starts_with($key, '_');
    }
}
