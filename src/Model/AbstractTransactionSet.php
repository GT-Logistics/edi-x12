<?php

declare(strict_types=1);

namespace Gtlogistics\EdiX12\Model;

abstract class AbstractTransactionSet extends AbstractSegment implements TransactionSetInterface
{
    use HasSegmentsTrait;

    public function &__get(string $key): mixed
    {
        if ($this->isElement($key)) {
            // We need a temporal variable
            // to pass by reference the value
            $_ = parent::__get($key);

            return $_;
        }

        return $this->getSegment($key);
    }

    public function __set(string $key, mixed $value): void
    {
        if ($this->isElement($key)) {
            parent::__set($key, $value);

            return;
        }

        $this->setSegment($key, $value);
    }

    public function __isset(string $key): bool
    {
        if ($this->isElement($key)) {
            return parent::__isset($key);
        }

        return $this->hasSegment($key);
    }

    private function isElement(string $key): bool
    {
        return isset($this->aliases[$key]) || str_starts_with($key, '_');
    }
}
