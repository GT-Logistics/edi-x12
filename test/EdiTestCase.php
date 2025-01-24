<?php

declare(strict_types=1);

/*
 * Copyright (C) 2024 GT+ Logistics.
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301
 * USA
 */

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
        $expected = trim($expected);
        $value = trim($value);

        $this->assertSame($expected, $value);
    }
}
