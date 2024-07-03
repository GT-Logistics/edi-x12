<?php

declare(strict_types=1);

namespace Gtlogistics\EdiX12\Trailer;

use Gtlogistics\EdiX12\Model\AbstractSegment;

/**
 * @property int $numberOfIncludedFunctionalGroups @see $_01
 * @property int $_01 **Number of Included Functional Groups:** A count of the number of functional groups included in an interchange
 * @property int $interchangeControlNumber @see $_02
 * @property int $_02 **Interchange Control Number:** A control number assigned by the interchange sender
 */
class IeaTrailer extends AbstractSegment
{
    protected array $aliases = [
        'numberOfIncludedFunctionalGroups' => 1,
        'interchangeControlNumber' => 2,
    ];

    protected array $castings = [
        1 => 'int',
        2 => 'int',
    ];

    protected array $lengths = [
        1 => [1, 5],
        2 => [9, 9],
    ];

    protected array $required = [
        1 => true,
        2 => true,
    ];

    public function getId(): string
    {
        return 'IEA';
    }
}
