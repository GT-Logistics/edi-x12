<?php

namespace Gtlogistics\X12Parser\Trailer;

use Gtlogistics\X12Parser\Model\AbstractSegment;

/**
 * @property int $_01 **Number of Included Functional Groups:** A count of the number of functional groups included in an interchange
 * @property int $_02 **Interchange Control Number:** A control number assigned by the interchange sender
 */
class IeaTrailer extends AbstractSegment
{
    protected static array $castings = [
        1 => 'int',
        2 => 'int',
    ];

    protected static array $lengths = [
        1 => [1, 5],
        2 => [9, 9],
    ];

    protected static array $required = [
        1 => true,
        2 => true,
    ];

    public function getId(): string
    {
        return 'IEA';
    }
}
