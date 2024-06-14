<?php

namespace Gtlogistics\X12Parser\Model;

abstract class AbstractRelease implements ReleaseInterface
{
    /**
     * @param array<string, class-string<TransactionSetInterface>> $transactionSetClassMap
     * @param array<string, class-string<SegmentInterface>> $segmentClassMap
     */
    public function __construct(
        private array $transactionSetClassMap,
        private array $segmentClassMap,
    ) {
    }

    /**
     * @return class-string<TransactionSetInterface>
     */
    public function getTransactionSetClass(string $code): string
    {
        return $this->transactionSetClassMap[$code];
    }

    /**
     * @param class-string<TransactionSetInterface> $transactionSetClass
     */
    public function addTransactionSetClass(string $code, string $transactionSetClass): void
    {
        $this->transactionSetClassMap[$code] = $transactionSetClass;
    }

    public function removeTransactionSetClass(string $code): void
    {
        unset($this->transactionSetClassMap[$code]);
    }

    /**
     * @return class-string<SegmentInterface>
     */
    public function getSegmentClass(string $id): string
    {
        return $this->segmentClassMap[$id];
    }

    /**
     * @param class-string<SegmentInterface> $segmentClass
     */
    public function addSegmentClass(string $id, string $segmentClass): void
    {
        $this->segmentClassMap[$id] = $segmentClass;
    }

    public function removeSegmentClass(string $id): void
    {
        unset($this->segmentClassMap[$id]);
    }
}
