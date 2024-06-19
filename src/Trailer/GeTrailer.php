<?php

namespace Gtlogistics\X12Parser\Trailer;

use Gtlogistics\X12Parser\Model\AbstractSegment;

/**
 * @property int $_01 **Number of Transaction Sets Included:** Total number of transaction sets included in the functional group or interchange (transmission) group terminated by the trailer containing this data element
 * @property string $_02 **Group Control Number:** Assigned number originated and maintained by the sender
 */
class GeTrailer extends AbstractSegment
{
    protected static array $castings = [
        '_01' => 'int',
    ];

    protected static array $lengths = [
        '_01' => [1, 6],
        '_02' => [1, 9],
    ];

    protected static array $required = [
        '_01' => true,
        '_02' => true,
    ];

    public function getId(): string
    {
        return 'GE';
    }
}
