<?php

declare(strict_types=1);

namespace Gtlogistics\X12Parser\Trailer;

use Gtlogistics\X12Parser\Model\AbstractSegment;

/**
 * @property int $_01 **Number of Included Segments:** Total number of segments included in a transaction set including ST and SE segments
 * @property string $_02 **Transaction Set Control Number:** Identifying control number that must be unique within the transaction set functional group assigned by the originator for a transaction set
 */
class SeTrailer extends AbstractSegment
{
    protected array $castings = [
        1 => 'int',
    ];

    protected array $lengths = [
        1 => [1, 10],
        2 => [4, 9],
    ];

    protected array $required = [
        1 => true,
        2 => true,
    ];

    public function getId(): string
    {
        return 'SE';
    }
}
