<?php

namespace Gtlogistics\X12Parser\Model;

interface ReleaseInterface
{
    /**
     * @return class-string
     */
    public function getTransactionSetClass(string $code): string;

    /**
     * @return class-string
     */
    public function getSegmentClass(string $id): string;
}
