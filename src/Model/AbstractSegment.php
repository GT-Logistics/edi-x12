<?php

namespace Gtlogistics\X12Parser\Model;

use Webmozart\Assert\Assert;

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

        for ($i = 0, $iMax = max(array_keys($this->elements)); $i <= $iMax; $i++) {
            $key = '_' . str_pad((string) $i, 2, '0', STR_PAD_LEFT);

            $value = $this->elements[$i] ?? '';
            [$min, $max] = $this->getLengths($key);
            $casting = $this->getCasting($key);
            $required = $this->getRequired($key);

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
        $lengths = $this->getLengths($key);
        $value = $this->elements[$this->parseIndex($key)];

        return $this->convertTo($value, $casting, $lengths);
    }

    public function __set(string $key, mixed $value): void
    {
        $casting = $this->getCasting($key);
        $lengths = $this->getLengths($key);
        $required = $this->getRequired($key);
        $value = $this->convertFrom($value, $casting, $lengths, $required);

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

    /**
     * @return array{int, int}
     */
    private function getLengths(string $key): array
    {
        return $this->lengths[$key] ?? [-1, -1];
    }

    private function getRequired(string $key): bool
    {
        return $this->required[$key] ?? false;
    }

    /**
     * @param array{int, int} $lengths
     */
    private function convertTo(string $value, string $type, array $lengths): mixed
    {
        if ($value === '') {
            return null;
        }
        if (is_a($type, \BackedEnum::class, true)) {
            return $type::from($value);
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

        return match ($type) {
            'int' => (int) $value,
            'float' => (float) $value,
            default => $value,
        };
    }

    /**
     * @param array{int, int} $lengths
     */
    private function convertFrom(mixed $value, string $type, array $lengths, bool $required): string
    {
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

        throw new \RuntimeException('Not a valid value');
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
