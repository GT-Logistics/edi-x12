<?php

declare(strict_types=1);

namespace Gtlogistics\EdiX12\Loaders;

use Gtlogistics\EdiX12\Schema\Release;

interface SchemaLoaderInterface
{
    /**
     * @param string[] $transactionSetIds
     */
    public function getRelease(string $releaseId, array $transactionSetIds = []): Release;
}
