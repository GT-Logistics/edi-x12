<?php

declare(strict_types=1);

namespace Gtlogistics\X12Parser\Schema\Types;

final readonly class EnumType implements TypeInterface
{
    /**
     * @param array<string, string> $availableValues
     */
    public function __construct(
        private string $name,
        private array $availableValues,
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return 'string'
     */
    public function getNativeType(): string
    {
        return 'string';
    }

    /**
     * @return array<string, string>
     */
    public function getAvailableValues(): array
    {
        return $this->availableValues;
    }
}
