<?php

namespace Gtlogistics\X12Parser\Schema;

use Gtlogistics\X12Parser\Schema\Types\TypeInterface;

final readonly class Element
{
    public function __construct(
        private string $id,
        private string $description,
        private TypeInterface $type,
        private bool $required,
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getType(): TypeInterface
    {
        return $this->type;
    }

    public function isRequired(): bool
    {
        return $this->required;
    }
}
