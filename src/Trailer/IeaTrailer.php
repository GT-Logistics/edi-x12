<?php

namespace Gtlogistics\X12Parser\Trailer;

use Gtlogistics\X12Parser\Model\AbstractSegment;

/**
 * @property int $_01 **Number of Included Functional Groups:** A count of the number of functional groups included in an interchange
 * @property int $_02 **Interchange Control Number:** A control number assigned by the interchange sender
 */
class IeaTrailer extends AbstractSegment
{
    protected array $castings = [
        '_01' => 'int',
        '_02' => 'int',
    ];

    protected array $lengths = [
        '_01' => [1, 5],
        '_02' => [9, 9],
    ];

    protected array $required = [
        '_01' => true,
        '_02' => true,
    ];

    public function getId(): string
    {
        return 'IEA';
    }
}
