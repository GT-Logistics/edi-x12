<?php

namespace Gtlogistics\X12Parser\Model;

use Gtlogistics\X12Parser\Qualifier\TransactionSetIdentifierCode;

interface ReleaseInterface
{
    /**
     * @return class-string<TransactionSetInterface>
     */
    public function getTransactionSetClass(TransactionSetIdentifierCode $code): string;

    /**
     * @return class-string<SegmentInterface>
     */
    public function getSegmentClass(string $id): string;
}
