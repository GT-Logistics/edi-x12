<?php

declare(strict_types=1);

namespace Gtlogistics\EdiX12;

use Gtlogistics\EdiX12\Heading\IsaHeading;

final class Edi
{
    /**
     * @var IsaHeading[]
     */
    public array $ISA;

    /**
     * @param IsaHeading[] $ISA
     */
    public function __construct(array $ISA = [])
    {
        $this->ISA = $ISA;
    }
}
