<?php

namespace Gtlogistics\X12Parser\Model;

use function _PHPStan_1310ce93b\RingCentral\Psr7\str;

abstract class AbstractSegment
{
    protected array $castings = [];

    public function __construct(private array $elements)
    {
    }

    public function __get(string $key): string
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
            'date', 'time' => new \DateTime($value),
            default => trim($value),
        };
    }

    private function convertFrom(mixed $value, string $type): string
    {
        return (string) $value;
    }
}
