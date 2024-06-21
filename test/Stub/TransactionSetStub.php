<?php

namespace Gtlogistics\X12Parser\Test\Stub;

use Gtlogistics\X12Parser\Model\SegmentInterface;
use Gtlogistics\X12Parser\Model\TransactionSetInterface;

class TransactionSetStub implements TransactionSetInterface
{
    public function __construct()
    {
    }

    public function getId(): string
    {
        return 'ST';
    }

    public function getElements(): array
    {
        return [];
    }

    public function setElements(array $elements): void
    {
    }

    public function getSegments(): array
    {
        return [];
    }

    public function setSegments(array $segments): void
    {
    }
}
