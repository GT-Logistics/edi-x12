<?php

declare(strict_types=1);

namespace Gtlogistics\X12Parser\Test\Mock;

use Gtlogistics\X12Parser\Model\AbstractSegment;

/**
 * @property mixed $_01
 * @property mixed $test
 */
class SegmentMock extends AbstractSegment
{
    protected array $aliases = [
        'test' => 1,
    ];

    /**
     * @param array<int, string> $castings
     */
    public function setCastings(array $castings): void
    {
        $this->castings = $castings;
    }

    /**
     * @param array<int, array{int, int}> $lengths
     */
    public function setLengths(array $lengths): void
    {
        $this->lengths = $lengths;
    }

    /**
     * @param array<int, true> $required
     */
    public function setRequired(array $required): void
    {
        $this->required = $required;
    }

    public function getId(): string
    {
        return 'TST';
    }
}
