<?php

declare(strict_types=1);

namespace Gtlogistics\EdiX12\Schema\Types;

interface TypeInterface
{
    public function getNativeType(): string;
}
