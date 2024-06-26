<?php

declare(strict_types=1);

namespace Gtlogistics\X12Parser\Generator;

use Gtlogistics\X12Parser\Model\SegmentInterface;
use Gtlogistics\X12Parser\Model\TransactionSetInterface;

final class ClassMap
{
    /**
     * @var array<string, class-string<TransactionSetInterface>>
     */
    private array $transactionSetClassMap = [];

    /**
     * @var array<string, class-string<SegmentInterface>>
     */
    private array $segmentClassMap = [];

    /**
     * @return array<string, class-string<TransactionSetInterface>>
     */
    public function getTransactionSetClassMap(): array
    {
        return $this->transactionSetClassMap;
    }

    /**
     * @param class-string<TransactionSetInterface> $transactionSetClass
     */
    public function addTransactionSetClass(string $code, string $transactionSetClass): void
    {
        $this->transactionSetClassMap[$code] = $transactionSetClass;
    }

    /**
     * @return array<string, class-string<SegmentInterface>>
     */
    public function getSegmentClassMap(): array
    {
        return $this->segmentClassMap;
    }

    /**
     * @param class-string<SegmentInterface> $segmentClass
     */
    public function addSegmentClass(string $id, string $segmentClass): void
    {
        $this->segmentClassMap[$id] = $segmentClass;
    }
}
