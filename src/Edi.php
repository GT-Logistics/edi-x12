<?php

declare(strict_types=1);

namespace Gtlogistics\X12Parser;

use Gtlogistics\X12Parser\Heading\IsaHeading;

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
