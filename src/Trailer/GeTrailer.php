<?php

namespace Gtlogistics\X12Parser\Trailer;

use Gtlogistics\X12Parser\Model\AbstractSegment;

/**
 * @property int $_01 **Number of Transaction Sets Included:** Total number of transaction sets included in the functional group or interchange (transmission) group terminated by the trailer containing this data element
 * @property int $_02 **Group Control Number:** Assigned number originated and maintained by the sender
 */
class GeTrailer extends AbstractSegment
{
    protected static array $castings = [
        1 => 'int',
        2 => 'int',
    ];

    protected static array $lengths = [
        1 => [1, 6],
        2 => [1, 9],
    ];

    protected static array $required = [
        1 => true,
        2 => true,
    ];

    public function getId(): string
    {
        return 'GE';
    }
}
