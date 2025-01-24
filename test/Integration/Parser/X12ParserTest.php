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

namespace Gtlogistics\EdiX12\Test\Integration\Parser;

use Gtlogistics\EdiX12\Edi;
use Gtlogistics\EdiX12\Heading\GsHeading;
use Gtlogistics\EdiX12\Heading\IsaHeading;
use Gtlogistics\EdiX12\Model\AbstractLoop;
use Gtlogistics\EdiX12\Model\AbstractRelease;
use Gtlogistics\EdiX12\Model\AbstractSegment;
use Gtlogistics\EdiX12\Model\AbstractTransactionSet;
use Gtlogistics\EdiX12\Model\HasSegmentsTrait;
use Gtlogistics\EdiX12\Parser\X12Parser;
use Gtlogistics\EdiX12\Release\Release00401;
use Gtlogistics\EdiX12\Test\EdiTestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversTrait;

#[CoversClass(X12Parser::class)]
#[CoversClass(Edi::class)]
#[CoversClass(GsHeading::class)]
#[CoversClass(IsaHeading::class)]
#[CoversClass(AbstractRelease::class)]
#[CoversClass(AbstractTransactionSet::class)]
#[CoversClass(AbstractLoop::class)]
#[CoversClass(AbstractSegment::class)]
#[CoversTrait(HasSegmentsTrait::class)]
class X12ParserTest extends EdiTestCase
{
    public function testParsing204(): void
    {
        $release = new Release00401();
        $parser = new X12Parser(['00401' => $release]);
        $edi = $parser->parse($this->loadFixture('204.edi'));

        $this->assertEdi204($edi);
    }
}
