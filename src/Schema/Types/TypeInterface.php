<?php

declare(strict_types=1);

namespace Gtlogistics\X12Parser\Schema\Types;

interface TypeInterface
{
    public function getNativeType(): string;
}
