<?php

namespace Gtlogistics\X12Parser\Trailer;

use Gtlogistics\X12Parser\Model\AbstractSegment;

/**
 * @property int $_01 **Number of Included Segments:** Total number of segments included in a transaction set including ST and SE segments
 * @property int $_02 **Transaction Set Control Number:** Identifying control number that must be unique within the transaction set functional group assigned by the originator for a transaction set
 */
class SeTrailer extends AbstractSegment
{
    protected array $castings = [
        '_01' => 'int',
        '_02' => 'int',
    ];

    public function getId(): string
    {
        return 'SE';
    }
}
