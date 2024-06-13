<?php

namespace Gtlogistics\X12Parser\Model;

interface ReleaseInterface
{
    /**
     * @return class-string<TransactionSetInterface>
     */
    public function getTransactionSetClass(string $code): string;

    /**
     * @return class-string<SegmentInterface>
     */
    public function getSegmentClass(string $id): string;
}
