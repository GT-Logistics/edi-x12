<?php

namespace Gtlogistics\X12Parser\Test;

use PHPUnit\Framework\TestCase;
use function Safe\file_get_contents;

class EdiTestCase extends TestCase
{
    protected function loadFixture(string $fixture): string
    {
        return file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'Fixtures' . DIRECTORY_SEPARATOR . $fixture);
    }

    protected function assertDate(string $expected, mixed $value): void
    {
        $this->assertInstanceOf(\DateTimeInterface::class, $value);
        $this->assertSame($expected, $value->format('Y-m-d'));
    }

    protected function assertTime(string $expected, mixed $value): void
    {
        $this->assertInstanceOf(\DateTimeInterface::class, $value);
        $this->assertSame($expected, $value->format('H:i'));
    }

    protected function assertEnum(\BackedEnum $expected, mixed $value): void
    {
        $this->assertInstanceOf($expected::class, $value);
        $this->assertSame($expected, $value);
    }

    protected function assertEdi(string $expected, string $value): void
    {
        $expected = str_replace(["\n", "\t", "\r"], '', $expected);
        $value = str_replace(["\n", "\t", "\r"], '', $value);

        $this->assertSame($expected, $value);
    }
}
