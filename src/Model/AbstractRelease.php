<?php

namespace Gtlogistics\X12Parser\Model;

use Gtlogistics\X12Parser\Qualifier\TransactionSetIdentifierCode;

abstract class AbstractRelease implements ReleaseInterface
{
    /**
     * @param array<string, class-string> $transactionSetClassMap
     * @param array<string, class-string> $segmentClassMap
     */
    public function __construct(
        private array $transactionSetClassMap,
        private array $segmentClassMap,
    ) {
    }

    public function getTransactionSetClass(TransactionSetIdentifierCode $code): string
    {
        return $this->transactionSetClassMap[$code->value];
    }

    public function addTransactionSetClass(string $code, string $transactionSetClass): void
    {
        $this->transactionSetClassMap[$code] = $transactionSetClass;
    }

    public function removeTransactionSetClass(string $code): void
    {
        unset($this->transactionSetClassMap[$code]);
    }

    public function getSegmentClass(string $id): string
    {
        return $this->segmentClassMap[$id];
    }

    public function addSegmentClass(string $id, string $segmentClass): void
    {
        $this->segmentClassMap[$id] = $segmentClass;
    }

    public function removeSegmentClass(string $id): void
    {
        unset($this->segmentClassMap[$id]);
    }
}
