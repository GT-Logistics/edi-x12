<?php

namespace Gtlogistics\X12Parser\Trailer;

use Gtlogistics\X12Parser\Model\AbstractSegment;

/**
 * @property int $_01 **Number of Included Segments:** Total number of segments included in a transaction set including ST and SE segments
 * @property string $_02 **Transaction Set Control Number:** Identifying control number that must be unique within the transaction set functional group assigned by the originator for a transaction set
 */
class SeTrailer extends AbstractSegment
{
    protected static array $castings = [
        '_01' => 'int',
    ];

    protected static array $lengths = [
        '_01' => [1, 10],
        '_02' => [4, 9],
    ];

    protected static array $required = [
        '_01' => true,
        '_02' => true,
    ];

    public function getId(): string
    {
        return 'SE';
    }
}
