<?php

namespace Gtlogistics\X12Parser\Test\Mock;

use Gtlogistics\X12Parser\Model\AbstractSegment;

/**
 * @property mixed $_01
 */
class SegmentMock extends AbstractSegment
{
    /**
     * @param array<int, string> $castings
     */
    public function setCastings(array $castings): void
    {
        self::$castings = $castings;
    }

    /**
     * @param array<int, array{int, int}> $lengths
     */
    public function setLengths(array $lengths): void
    {
        self::$lengths = $lengths;
    }

    /**
     * @param array<int, true> $required
     */
    public function setRequired(array $required): void
    {
        self::$required = $required;
    }

    public function getId(): string
    {
        return 'TST';
    }
}