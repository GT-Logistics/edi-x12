<?php

namespace Gtlogistics\X12Parser\Model;

abstract class AbstractSegment implements SegmentInterface
{
    protected array $castings = [];

    protected array $paddings = [];

    /**
     * @var mixed[]
     */
    private array $elements = [];

    public function __construct()
    {
        $this->elements[0] = $this->getId();
    }

    public function getElements(): array
    {
        $elements = [];

        for ($i = 0, $iMax = max(array_keys($this->elements)); $i <= $iMax; $i++) {
            $key = '_' . str_pad($i, 2, '0', STR_PAD_LEFT);
            $value = $this->elements[$i] ?? '';
            $padding = $this->getPadding($key);
            $casting = $this->getCasting($key);

            if (in_array($casting, ['int', 'float'])) {
                $value = str_pad($value, $padding, '0', STR_PAD_LEFT);
            } else {
                $value = str_pad($value, $padding);
            }

            $elements[$i] = $value;
        }

        return $elements;
    }

    public function setElements(array $elements): void
    {
        $this->elements = $elements;
    }

    public function __get(string $key): mixed
    {
        $casting = $this->getCasting($key);
        $value = $this->elements[$this->parseIndex($key)];

        return $this->convertTo($value, $casting);
    }

    public function __set(string $key, mixed $value): void
    {
        $casting = $this->getCasting($key);
        $value = $this->convertFrom($value, $casting);

        $this->elements[$this->parseIndex($key)] = $value;
    }

    public function __isset(string $key): bool
    {
        return isset($this->elements[$this->parseIndex($key)]);
    }

    private function parseIndex(string $key): int
    {
        return (int) substr($key, -2);
    }

    private function getCasting(string $key): string
    {
        return $this->castings[$key] ?? 'string';
    }

    private function getPadding(string $key): ?int
    {
        return $this->paddings[$key] ?? -1;
    }

    /**
     * @param string $value
     * @param string $type
     * @return mixed
     * @throws \Exception
     */
    private function convertTo(string $value, string $type): mixed
    {
        if ($value === '') {
            return null;
        }
        if (is_a($type, \BackedEnum::class, true)) {
            return $type::from($value);
        }

        return match ($type) {
            'int' => (int) $value,
            'float' => (float) $value,
            'date' => $this->convertToDateTime($value, ['Ymd', 'ymd'])->setTime(0, 0),
            'time' => $this->convertToDateTime($value, ['Hisu', 'His', 'Hi'])->setDate(1970, 1, 1),
            default => $value,
        };
    }

    private function convertFrom(mixed $value, string $type): string
    {
        if ($value === null) {
            return '';
        }
        if (is_a($type, \BackedEnum::class, true)) {
            return $value->value;
        }

        return match ($type) {
            'date' => $value->format('ymd'),
            'time' => $value->format('Hi'),
            default => (string) $value,
        };
    }

    /**
     * @param string[] $formats
     */
    private function convertToDateTime(string $value, array $formats): \DateTimeImmutable
    {
        foreach ($formats as $format) {
            $converted = \DateTimeImmutable::createFromFormat($format, $value);

            if ($converted !== false) {
                return $converted;
            }
        }

        throw new \RuntimeException('Invalid date/time format');
    }
}
