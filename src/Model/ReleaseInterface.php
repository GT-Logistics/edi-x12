<?php

declare(strict_types=1);

namespace Gtlogistics\X12Parser\Model;

interface ReleaseInterface
{
    public function supports(string $releaseId): bool;

    public function makeTransactionSet(string $code): TransactionSetInterface;

    public function makeSegment(string $id): SegmentInterface;
}
