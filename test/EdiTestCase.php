<?php

declare(strict_types=1);

namespace Gtlogistics\EdiX12\Test;

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
        $this->assertSame($expected . ' 00:00:00.000', $value->format('Y-m-d H:i:s.v'));
    }

    protected function assertTime(string $expected, mixed $value): void
    {
        $this->assertInstanceOf(\DateTimeInterface::class, $value);
        $this->assertSame('1970-01-01 ' . $expected, $value->format('Y-m-d H:i:s.v'));
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
