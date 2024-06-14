<?php

namespace Gtlogistics\X12Parser\Model;

abstract class AbstractSegment implements SegmentInterface
{
    /**
     * @var array<string, string>
     */
    protected array $castings = [];

    /**
     * @var array<string, array{int, int}>
     */
    protected array $lengths = [];

    /**
     * @var array<string, true>
     */
    protected array $required = [];

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
            [$min, $max] = $this->getLengths($key);
            $casting = $this->getCasting($key);
            $required = $this->getRequired($key);

            if ($required) {
                if (in_array($casting, ['int', 'float'])) {
                    $value = str_pad($value, $min, '0', STR_PAD_LEFT);
                } else {
                    $value = str_pad($value, $min);
                }

                if ($max >= 0) {
                    $value = substr($value, 0, $max);
                }
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
        $lengths = $this->getLengths($key);
        $value = $this->convertFrom($value, $casting, $lengths);

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

    private function getLengths(string $key): array
    {
        return $this->lengths[$key] ?? [-1, -1];
    }

    private function getRequired(string $key): bool
    {
        return $this->required[$key] ?? false;
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

    private function convertFrom(mixed $value, string $type, array $lengths): string
    {
        if ($value === null) {
            return '';
        }
        if (is_a($type, \BackedEnum::class, true)) {
            return $value->value;
        }

        [, $max] = $lengths;
        if ($type === 'date') {
            /** @var $value \DateTimeInterface */
            return match ($max) {
                8 => $value->format('Ymd'),
                6 => $value->format('ymd'),
            };
        }
        if ($type === 'time') {
            /** @var $value \DateTimeInterface */
            return match ($max) {
                8 => $value->format('Hisv'),
                6 => $value->format('His'),
                4 => $value->format('Hi'),
            };
        }

        return (string) $value;
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
