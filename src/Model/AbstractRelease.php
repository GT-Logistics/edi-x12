<?php

declare(strict_types=1);

namespace Gtlogistics\X12Parser\Model;

abstract class AbstractRelease implements ReleaseInterface
{
    /**
     * @var array<string, class-string<TransactionSetInterface>>
     */
    protected array $transactionSetClassMap;

    /**
     * @var array<string, class-string<SegmentInterface>>
     */
    protected array $segmentClassMap;

    /**
     * @param array<string, class-string<TransactionSetInterface>>|null $transactionSetClassMap
     * @param array<string, class-string<SegmentInterface>>|null $segmentClassMap
     */
    public function __construct(
        ?array $transactionSetClassMap = null,
        ?array $segmentClassMap = null,
    ) {
        if ($transactionSetClassMap !== null) {
            $this->transactionSetClassMap = $transactionSetClassMap;
        }
        if ($segmentClassMap !== null) {
            $this->segmentClassMap = $segmentClassMap;
        }
    }

    public function makeTransactionSet(string $code): TransactionSetInterface
    {
        $class = $this->transactionSetClassMap[$code];

        return new $class();
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

    public function makeSegment(string $id): SegmentInterface
    {
        $class = $this->segmentClassMap[$id];

        return new $class();
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
