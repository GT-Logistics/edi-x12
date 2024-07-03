<?php

declare(strict_types=1);

namespace Gtlogistics\EdiX12\Schema;

use Gtlogistics\EdiX12\Schema\Types\TypeInterface;

final readonly class Element
{
    public function __construct(
        private int $index,
        private string $description,
        private TypeInterface $type,
        private int $minLength,
        private int $maxLength,
        private bool $required,
    ) {
    }

    public function getIndex(): int
    {
        return $this->index;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getType(): TypeInterface
    {
        return $this->type;
    }

    public function getMinLength(): int
    {
        return $this->minLength;
    }

    public function getMaxLength(): int
    {
        return $this->maxLength;
    }

    public function isRequired(): bool
    {
        return $this->required;
    }
}
