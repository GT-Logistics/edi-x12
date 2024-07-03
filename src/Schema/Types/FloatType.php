<?php

declare(strict_types=1);

namespace Gtlogistics\EdiX12\Schema\Types;

final class FloatType implements TypeInterface
{
    public function getNativeType(): string
    {
        return 'float';
    }
}
