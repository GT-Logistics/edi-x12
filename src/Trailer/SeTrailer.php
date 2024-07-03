<?php

declare(strict_types=1);

namespace Gtlogistics\EdiX12\Trailer;

use Gtlogistics\EdiX12\Model\AbstractSegment;

/**
 * @property int $numberOfIncludedSegments @see $_01
 * @property int $_01 **Number of Included Segments:** Total number of segments included in a transaction set including ST and SE segments
 * @property string $transactionSetControlNumber @see $_02
 * @property string $_02 **Transaction Set Control Number:** Identifying control number that must be unique within the transaction set functional group assigned by the originator for a transaction set
 */
class SeTrailer extends AbstractSegment
{
    protected array $aliases = [
        'numberOfIncludedSegments' => 1,
        'transactionSetControlNumber' => 2,
    ];

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
