<?php

declare(strict_types=1);

namespace Gtlogistics\X12Parser\Schema;

final class Release
{
    /**
     * @var TransactionSet[]
     */
    private array $transactionSets = [];

    public function __construct(
        private readonly string $id,
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return TransactionSet[]
     */
    public function getTransactionSets(): array
    {
        return $this->transactionSets;
    }

    public function addTransactionSet(TransactionSet $transactionSet): void
    {
        $this->transactionSets[] = $transactionSet;
    }
}
