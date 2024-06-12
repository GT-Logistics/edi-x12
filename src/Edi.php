<?php

namespace Gtlogistics\X12Parser;

use Gtlogistics\X12Parser\Heading\IsaHeading;

final class Edi
{
    /**
     * @var non-empty-list<IsaHeading>
     */
    public array $ISA;

    public function __construct(array $ISA = [])
    {
        $this->ISA = $ISA;
    }
}
