<?php

namespace Gtlogistics\X12Parser\Model;

use Webmozart\Assert\Assert;

abstract class AbstractSegment implements SegmentInterface
{
    /**
     * @var array<int, string>
     */
    protected array $castings = [];

    /**
     * @var array<int, array{int, int}>
     */
    protected array $lengths = [];

    /**
     * @var array<int, true>
     */
    protected array $required = [];

    /**
     * @var string[]
     */
    private array $elements = [];

    public function __construct()
    {
        $this->elements[0] = $this->getId();
    }

    public function getElements(): array
    {
        $elements = [];

        for ($index = 0, $lastIndex = max(array_keys($this->elements)); $index <= $lastIndex; $index++) {
            $value = $this->elements[$index] ?? '';

            $elements[$index] = $this->padValue($index, $value);
        }

        return $elements;
    }

    public function setElements(array $elements): void
    {
        $this->elements = $elements;
    }

    public function __get(string $key): mixed
    {
        $index = $this->parseIndex($key);
        $value = $this->elements[$index] ?? '';

        return $this->convertTo($index, $value);
    }

    public function __set(string $key, mixed $value): void
    {
        $index = $this->parseIndex($key);
        $value = $this->convertFrom($index, $value);

        $this->elements[$index] = $value;
    }

    public function __isset(string $key): bool
    {
        return isset($this->elements[$this->parseIndex($key)]);
    }

    private function parseIndex(string $key): int
    {
        return (int) substr($key, -2);
    }

    private function getCasting(int $index): string
    {
        return $this->castings[$index] ?? 'string';
    }

    /**
     * @return array{int, int}
     */
    private function getLengths(int $index): array
    {
        return $this->lengths[$index] ?? [-1, -1];
    }

    private function getRequired(int $index): bool
    {
        return $this->required[$index] ?? false;
    }

    private function padValue(int $index, string $value): string
    {
        [$min, $max] = $this->getLengths($index);
        $casting = $this->getCasting($index);
        $required = $this->getRequired($index);

        if ($required || $value !== '') {
            if (in_array($casting, ['int', 'float'])) {
                Assert::numeric($value);
                $value = str_pad($value, $min, '0', STR_PAD_LEFT);
            } else {
                Assert::string($value);
                $value = str_pad($value, $min);
            }

            if ($max >= 0) {
                $value = substr($value, 0, $max);
            }
        }

        return $value;
    }

    private function convertTo(int $index, string $value): mixed
    {
        $type = $this->getCasting($index);
        $lengths = $this->getLengths($index);
        $required = $this->getRequired($index);

        if ($required) {
            Assert::stringNotEmpty($value);
        }
        if ($value === '') {
            return null;
        }

        if (is_a($type, \BackedEnum::class, true)) {
            return $type::from($value);
        }

        if ($type === 'int') {
            Assert::numeric($value);

            return (int) $value;
        }
        if ($type === 'float') {
            Assert::numeric($value);

            return (float) $value;
        }
        if ($type === 'string') {
            Assert::string($value);

            return $value;
        }

        [, $max] = $lengths;
        if ($type === 'date') {
            $dateFormats = [];

            if ($max >= 8) {
                $dateFormats[] = 'Ymd';
            }
            if ($max >= 6) {
                $dateFormats[] = 'ymd';
            }

            return $this->convertToDateTime($value, $dateFormats)->setTime(0, 0);
        }
        if ($type === 'time') {
            $timeFormats = [];

            if ($max >= 8) {
                $timeFormats[] = 'Hisu';
            }
            if ($max >= 6) {
                $timeFormats[] = 'His';
            }
            if ($max >= 4) {
                $timeFormats[] = 'Hi';
            }

            return $this->convertToDateTime($value, $timeFormats)->setDate(1970, 1, 1);
        }

        throw new \InvalidArgumentException(sprintf('Not a valid type "%s"', $type));
    }

    private function convertFrom(int $index, mixed $value): string
    {
        $type = $this->getCasting($index);
        $lengths = $this->getLengths($index);
        $required = $this->getRequired($index);

        if ($required) {
            Assert::notNull($value);
        }
        if ($value === null) {
            return '';
        }

        if ($type === 'int') {
            Assert::integer($value);

            return (string) $value;
        }
        if ($type === 'float') {
            Assert::float($value);

            return (string) $value;
        }
        if ($type === 'string') {
            Assert::string($value);

            return $value;
        }

        if (is_a($type, \BackedEnum::class, true)) {
            Assert::isInstanceOf($value, $type);

            return (string) $value->value;
        }

        [, $max] = $lengths;
        if ($type === 'date') {
            Assert::isInstanceOf($value, \DateTimeInterface::class);

            return match ($max) {
                8 => $value->format('Ymd'),
                6 => $value->format('ymd'),
                default => throw new \RuntimeException('Not a valid length format'),
            };
        }
        if ($type === 'time') {
            Assert::isInstanceOf($value, \DateTimeInterface::class);

            return match ($max) {
                8 => $value->format('Hisv'),
                6 => $value->format('His'),
                4 => $value->format('Hi'),
                default => throw new \RuntimeException('Not a valid length format'),
            };
        }

        throw new \InvalidArgumentException(sprintf('Not a valid type "%s"', $type));
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

        throw new \DateMalformedStringException('Invalid Date/Time string');
    }
}
