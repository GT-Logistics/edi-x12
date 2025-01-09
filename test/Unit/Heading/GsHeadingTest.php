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

use Gtlogistics\EdiX12\Heading\GsHeading;
use Gtlogistics\EdiX12\Qualifier\FunctionalIdentifierCode;
use Gtlogistics\EdiX12\Qualifier\ResponsibleAgencyCode;
use Gtlogistics\EdiX12\Qualifier\VersionReleaseIndustryIdentifierCode;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(GsHeading::class)]
class GsHeadingTest extends TestCase
{
    public function testQualifiersAsStrings(): void
    {
        $isa = new GsHeading();
        $isa->_01 = 'AA';
        $isa->_07 = 'X';
        $isa->_08 = '004000';

        $this->assertSame('AA', $isa->_01);
        $this->assertSame('X', $isa->_07);
        $this->assertSame('004000', $isa->_08);
    }

    public function testQualifiersAsEnums(): void
    {
        $isa = new GsHeading();
        $isa->_01 = FunctionalIdentifierCode::AA;
        $isa->_07 = ResponsibleAgencyCode::X;
        $isa->_08 = VersionReleaseIndustryIdentifierCode::_004000;

        $this->assertSame('AA', $isa->_01);
        $this->assertSame('X', $isa->_07);
        $this->assertSame('004000', $isa->_08);
    }
}
