<?php

namespace Gtlogistics\X12Parser\Model;

use Gtlogistics\X12Parser\Qualifier\TransactionSetIdentifierCode;

abstract class AbstractTransactionSet extends AbstractSegment implements TransactionSetInterface
{
    protected array $castings = [
        'ST01' => TransactionSetIdentifierCode::class,
    ];

    /**
     * @var (SegmentInterface|LoopInterface)[]
     */
    private array $segments = [];

    public function getSegments(): array
    {
        return $this->segments;
    }

    public function setSegments(array $segments): void
    {
        $this->segments = $segments;
    }

    public function __get(string $key): mixed
    {
        if ($this->isElement($key)) {
            return parent::__get($key);
        }

        return $this->segments[$key];
    }

    public function __set(string $key, mixed $value): void
    {
        if ($this->isElement($key)) {
            parent::__set($key, $value);

            return;
        }

        $this->segments[$key] = $value;
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
        return is_numeric(substr($key, -2));
    }
}
