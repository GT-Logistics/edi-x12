<?php

namespace Gtlogistics\X12Parser\Trailer;

use Gtlogistics\X12Parser\Model\AbstractSegment;

/**
 * @property int $_01 **Number of Included Functional Groups:** A count of the number of functional groups included in an interchange
 * @property string $_02 **Interchange Control Number:** A control number assigned by the interchange sender
 */
class IeaTrailer extends AbstractSegment
{
    protected static array $castings = [
        '_01' => 'int',
    ];

    protected static array $lengths = [
        '_01' => [1, 5],
        '_02' => [9, 9],
    ];

    protected static array $required = [
        '_01' => true,
        '_02' => true,
    ];

    public function getId(): string
    {
        return 'IEA';
    }
}
