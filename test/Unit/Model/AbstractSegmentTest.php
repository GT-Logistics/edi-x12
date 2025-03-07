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

namespace Gtlogistics\EdiX12\Test\Unit\Model;

use Gtlogistics\EdiX12\Model\AbstractSegment;
use Gtlogistics\EdiX12\Test\EdiTestCase;
use Gtlogistics\EdiX12\Test\Mock\SegmentMock;
use Gtlogistics\EdiX12\Test\Stub\QualifierStub;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestWith;
use Safe\DateTimeImmutable;

#[CoversClass(AbstractSegment::class)]
class AbstractSegmentTest extends EdiTestCase
{
    #[TestWith(['hello', 'hello', 'string'])]
    #[TestWith([101, '00101', 'int'])]
    #[TestWith([100.1, '0100.1', 'float'])]
    public function testScalarCasting(mixed $expected, string $value, string $type): void
    {
        $mock = new SegmentMock();
        $mock->setCastings([1 => $type]);

        $mock->setElements([$value]);
        $this->assertSame($expected, $mock->_01);
        $this->assertSame($expected, $mock->test_01);
    }

    #[TestWith(['hello', 'hello', 'string'])]
    #[TestWith(['101', 101, 'int'])]
    #[TestWith(['100.1', 100.1, 'float'])]
    public function testScalarParsing(string $expected, mixed $value, string $type): void
    {
        $mock = new SegmentMock();
        $mock->setCastings([1 => $type]);

        $mock->_01 = $value;
        $elements = iterator_to_array($mock->getElements());

        $this->assertCount(1, $elements);
        $this->assertSame($expected, $elements[0]);
    }

    #[TestWith([QualifierStub::TEST_1])]
    #[TestWith([QualifierStub::TEST_2])]
    #[TestWith([QualifierStub::TEST_3])]
    public function testEnumCasting(QualifierStub $expected): void
    {
        $mock = new SegmentMock();
        $mock->setCastings([1 => QualifierStub::class]);

        $mock->setElements([$expected->value]);
        $this->assertEnum($expected, $mock->_01);
        $this->assertEnum($expected, $mock->test_01);
    }

    #[TestWith([QualifierStub::TEST_1])]
    #[TestWith([QualifierStub::TEST_2])]
    #[TestWith([QualifierStub::TEST_3])]
    public function testEnumParsing(QualifierStub $expected): void
    {
        $mock = new SegmentMock();
        $mock->setCastings([1 => $expected::class]);

        $mock->_01 = $expected;
        $elements = iterator_to_array($mock->getElements());

        $this->assertCount(1, $elements);
        $this->assertSame($expected->value, $elements[0]);
    }

    /**
     * @param array{int, int} $length
     */
    #[TestWith(['2024-01-01', '20240101', [8, 8]])]
    #[TestWith(['2024-12-31', '20241231', [8, 8]])]
    #[TestWith(['2024-01-01', '240101', [6, 6]])]
    #[TestWith(['2024-12-31', '241231', [6, 6]])]
    public function testDateCasting(string $expected, string $value, array $length): void
    {
        $mock = new SegmentMock();
        $mock->setCastings([1 => 'date']);
        $mock->setLengths([1 => $length]);

        $mock->setElements([$value]);
        $this->assertDate($expected, $mock->_01);
        $this->assertDate($expected, $mock->test_01);
    }

    /**
     * @param array{int, int} $length
     */
    #[TestWith(['20240101', '2024-01-01', [8, 8]])]
    #[TestWith(['20241231', '2024-12-31', [8, 8]])]
    #[TestWith(['240101', '2024-01-01', [6, 6]])]
    #[TestWith(['241231', '2024-12-31', [6, 6]])]
    public function testDateParsing(string $expected, string $value, array $length): void
    {
        $mock = new SegmentMock();
        $mock->setCastings([1 => 'date']);
        $mock->setLengths([1 => $length]);

        $mock->_01 = new DateTimeImmutable($value);
        $elements = iterator_to_array($mock->getElements());

        $this->assertCount(1, $elements);
        $this->assertSame($expected, $elements[0]);
    }

    /**
     * @param array{int, int} $length
     */
    #[TestWith(['08:10:15.500', '08101550', [8, 8]])]
    #[TestWith(['18:20:35.750', '18203575', [8, 8]])]
    #[TestWith(['08:10:15.000', '081015', [6, 6]])]
    #[TestWith(['18:20:35.000', '182035', [6, 6]])]
    #[TestWith(['08:10:00.000', '0810', [4, 4]])]
    #[TestWith(['18:20:00.000', '1820', [4, 4]])]
    public function testTimeCasting(string $expected, string $value, array $length): void
    {
        $mock = new SegmentMock();
        $mock->setCastings([1 => 'time']);
        $mock->setLengths([1 => $length]);

        $mock->setElements([$value]);
        $this->assertTime($expected, $mock->_01);
        $this->assertTime($expected, $mock->test_01);
    }

    /**
     * @param array{int, int} $length
     */
    #[TestWith(['08101550', '08:10:15.500', [8, 8]])]
    #[TestWith(['18203575', '18:20:35.750', [8, 8]])]
    #[TestWith(['081015', '08:10:15.000', [6, 6]])]
    #[TestWith(['182035', '18:20:35.000', [6, 6]])]
    #[TestWith(['0810', '08:10:00.000', [4, 4]])]
    #[TestWith(['1820', '18:20:00.000', [4, 4]])]
    public function testTimeParsing(string $expected, string $value, array $length): void
    {
        $mock = new SegmentMock();
        $mock->setCastings([1 => 'time']);
        $mock->setLengths([1 => $length]);

        $mock->_01 = new DateTimeImmutable($value);
        $elements = iterator_to_array($mock->getElements());

        $this->assertCount(1, $elements);
        $this->assertSame($expected, $elements[0]);
    }

    #[TestWith(['string'])]
    #[TestWith(['int'])]
    #[TestWith(['float'])]
    #[TestWith(['date'])]
    #[TestWith(['time'])]
    #[TestWith([QualifierStub::class])]
    public function testNullableCasting(string $type): void
    {
        $mock = new SegmentMock();
        $mock->setCastings([1 => $type]);

        $mock->setElements(['']);
        $this->assertNull($mock->_01);
        $this->assertNull($mock->test_01);
    }

    #[TestWith(['string'])]
    #[TestWith(['int'])]
    #[TestWith(['float'])]
    #[TestWith(['date'])]
    #[TestWith(['time'])]
    #[TestWith([QualifierStub::class])]
    public function testNullableParsing(string $type): void
    {
        $mock = new SegmentMock();
        $mock->setCastings([1 => $type]);

        $mock->_01 = null;
        $elements = iterator_to_array($mock->getElements());

        $this->assertCount(1, $elements);
        $this->assertSame('', $elements[0]);
    }

    public function testRequiredCasting(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Expected a different value than "".');

        $mock = new SegmentMock();
        $mock->setRequired([1 => true]);

        $mock->setElements(['']);
        $mock->_01;
    }

    public function testRequiredParsing(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Expected a value other than null.');

        $mock = new SegmentMock();
        $mock->setRequired([1 => true]);

        $mock->_01 = null;
    }

    public function testInvalidTypeCasting(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Not a valid type "unknown"');

        $mock = new SegmentMock();
        $mock->setCastings([1 => 'unknown']);

        $mock->_01 = 'test';
    }

    public function testInvalidTypeParsing(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Not a valid type "unknown"');

        $mock = new SegmentMock();
        $mock->setCastings([1 => 'unknown']);

        $mock->setElements(['test']);
        $mock->_01;
    }

    #[TestWith(['error', 'int'])]
    #[TestWith(['error', 'float'])]
    public function testInvalidNumericCasting(mixed $value, string $type): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Expected a numeric. Got: string');

        $mock = new SegmentMock();
        $mock->setCastings([1 => $type]);

        $mock->setElements([$value]);
        $mock->_01;
    }

    public function testInvalidEnumCasting(): void
    {
        $this->expectException(\ValueError::class);
        $this->expectExceptionMessage('"error" is not a valid backing value for enum Gtlogistics\EdiX12\Test\Stub\QualifierStub');

        $mock = new SegmentMock();
        $mock->setCastings([1 => QualifierStub::class]);

        $mock->setElements(['error']);
        $mock->_01;
    }

    #[TestWith(['Expected an integer. Got: string', 'error', 'int'])]
    #[TestWith(['Expected a float. Got: string', 'error', 'float'])]
    #[TestWith(['Expected an instance of DateTimeInterface. Got: string', 'error', 'date'])]
    #[TestWith(['Expected an instance of DateTimeInterface. Got: string', 'error', 'time'])]
    #[TestWith(['Expected an instance of Gtlogistics\EdiX12\Test\Stub\QualifierStub. Got: string', 'error', QualifierStub::class])]
    public function testInvalidParsing(string $expected, mixed $value, string $type): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage($expected);

        $mock = new SegmentMock();
        $mock->setCastings([1 => $type]);

        $mock->_01 = $value;
    }

    /**
     * @param array{int, int} $length
     */
    #[TestWith(['date', [10, 10]])]
    #[TestWith(['date', [4, 4]])]
    #[TestWith(['time', [10, 10]])]
    #[TestWith(['time', [2, 2]])]
    public function testInvalidDateTimeLengths(string $type, array $length): void
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Not a valid length format');

        $date = new DateTimeImmutable('2024-01-01 00:00:00');

        $mock = new SegmentMock();
        $mock->setCastings([1 => $type]);
        $mock->setLengths([1 => $length]);

        $mock->_01 = $date;
    }

    #[TestWith(['2024-01-01'])]
    #[TestWith(['24-01-01'])]
    #[TestWith(['20241201'])]
    #[TestWith(['00000000'])]
    #[TestWith(['      '])]
    public function testInvalidDateCasting(string $dateString): void
    {
        $this->expectException(\DateMalformedStringException::class);
        $this->expectExceptionMessage('Invalid Date/Time string');

        $mock = new SegmentMock();
        $mock->setCastings([1 => 'date']);
        $mock->setLengths([1 => [6, 6]]);

        $mock->setElements([$dateString]);
        $mock->_01;
    }

    #[TestWith(['23:00:00.00'])]
    #[TestWith(['23:00:00'])]
    #[TestWith(['23000000'])]
    #[TestWith(['00000000'])]
    #[TestWith(['      '])]
    public function testInvalidTimeCasting(string $timeString): void
    {
        $this->expectException(\DateMalformedStringException::class);
        $this->expectExceptionMessage('Invalid Date/Time string');

        $mock = new SegmentMock();
        $mock->setCastings([1 => 'time']);
        $mock->setLengths([1 => [6, 6]]);

        $mock->setElements([$timeString]);
        $mock->_01;
    }
}
