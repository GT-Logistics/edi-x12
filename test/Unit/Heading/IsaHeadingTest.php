<?php

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

namespace Gtlogistics\EdiX12\Test\Unit\Heading;

use Gtlogistics\EdiX12\Heading\IsaHeading;
use Gtlogistics\EdiX12\Qualifier\AuthorizationInformationQualifier;
use Gtlogistics\EdiX12\Qualifier\InterchangeIDQualifier;
use Gtlogistics\EdiX12\Qualifier\SecurityInformationQualifier;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(IsaHeading::class)]
class IsaHeadingTest extends TestCase
{
    public function testQualifiersAsStrings(): void
    {
        $isa = new IsaHeading();
        $isa->_01 = '00';
        $isa->_03 = '01';
        $isa->_05 = '01';
        $isa->_07 = '02';

        $this->assertSame('00', $isa->_01);
        $this->assertSame('01', $isa->_03);
        $this->assertSame('01', $isa->_05);
        $this->assertSame('02', $isa->_07);
    }

    public function testQualifiersAsEnums(): void
    {
        $isa = new IsaHeading();
        $isa->_01 = AuthorizationInformationQualifier::_00;
        $isa->_03 = SecurityInformationQualifier::_01;
        $isa->_05 = InterchangeIDQualifier::_01;
        $isa->_07 = InterchangeIDQualifier::_02;

        $this->assertSame('00', $isa->_01);
        $this->assertSame('01', $isa->_03);
        $this->assertSame('01', $isa->_05);
        $this->assertSame('02', $isa->_07);
    }
}
