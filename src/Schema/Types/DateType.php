<?php

declare(strict_types=1);

namespace Gtlogistics\EdiX12\Schema\Types;

final class DateType implements TypeInterface
{
    public function getNativeType(): string
    {
        return \DateTimeInterface::class;
    }
}
