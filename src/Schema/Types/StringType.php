<?php

declare(strict_types=1);

namespace Gtlogistics\X12Parser\Schema\Types;

final class StringType implements TypeInterface
{
    public function getNativeType(): string
    {
        return 'string';
    }
}
