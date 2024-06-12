<?php

namespace Gtlogistics\X12Parser\Loaders;

use Gtlogistics\X12Parser\Schema\Release;

interface SchemaLoaderInterface
{
    /**
     * @param string[] $transactionSetIds
     */
    public function getRelease(string $releaseId, array $transactionSetIds = []): Release;
}
