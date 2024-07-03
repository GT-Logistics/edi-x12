<?php

declare(strict_types=1);

namespace Gtlogistics\EdiX12\Trailer;

use Gtlogistics\EdiX12\Model\AbstractSegment;

/**
 * @property int $numberOfTransactionSetsIncluded_01 *Number of Transaction Sets Included:** Total number of transaction sets included in the functional group or interchange (transmission) group terminated by the trailer containing this data element
 * @property int $_01 See $numberOfTransactionSetsIncluded_01
 * @property int $groupControlNumber_02 **Group Control Number:** Assigned number originated and maintained by the sender
 * @property int $_02 See $groupControlNumber_02
 */
final class GeTrailer extends AbstractSegment
{
    protected array $castings = [
        1 => 'int',
        2 => 'int',
    ];

    protected array $lengths = [
        1 => [1, 6],
        2 => [1, 9],
    ];

    protected array $required = [
        1 => true,
        2 => true,
    ];

    public function getId(): string
    {
        return 'GE';
    }
}
