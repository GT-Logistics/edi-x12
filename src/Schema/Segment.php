<?php

declare(strict_types=1);

namespace Gtlogistics\X12Parser\Schema;

final class Segment implements SegmentInterface
{
    /**
     * @var Element[]
     */
    private array $elements = [];

    public function __construct(
        private readonly string $id,
        private int $min = -1,
        private int $max = -1,
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getMin(): int
    {
        return $this->min;
    }

    public function setMin(int $min): void
    {
        $this->min = $min;
    }

    public function getMax(): int
    {
        return $this->max;
    }

    public function setMax(int $max): void
    {
        $this->max = $max;
    }

    /**
     * @return Element[]
     */
    public function getElements(): array
    {
        return $this->elements;
    }

    public function addElement(Element $element): void
    {
        $this->elements[] = $element;
    }
}
