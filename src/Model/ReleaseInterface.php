<?php

namespace Gtlogistics\X12Parser\Model;

interface ReleaseInterface
{
    public function makeTransactionSet(string $code): TransactionSetInterface;

    public function makeSegment(string $id): SegmentInterface;
}
