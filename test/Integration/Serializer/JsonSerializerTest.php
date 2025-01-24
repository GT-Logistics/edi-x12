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
use Gtlogistics\EdiX12\Model\AbstractSegment;
use Gtlogistics\EdiX12\Model\AbstractTransactionSet;
use Gtlogistics\EdiX12\Model\HasSegmentsTrait;
use Gtlogistics\EdiX12\Serializer\JsonSerializer;
use Gtlogistics\EdiX12\Serializer\X12Serializer;
use Gtlogistics\EdiX12\Test\EdiTestCase;
use Gtlogistics\EdiX12\Trailer\GeTrailer;
use Gtlogistics\EdiX12\Trailer\IeaTrailer;
use Gtlogistics\EdiX12\Trailer\SeTrailer;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversTrait;

#[CoversClass(JsonSerializer::class)]
#[CoversClass(Edi::class)]
#[CoversClass(GsHeading::class)]
#[CoversClass(GeTrailer::class)]
#[CoversClass(IsaHeading::class)]
#[CoversClass(IeaTrailer::class)]
#[CoversClass(SeTrailer::class)]
#[CoversClass(AbstractTransactionSet::class)]
#[CoversClass(AbstractSegment::class)]
#[CoversClass(AbstractLoop::class)]
#[CoversTrait(HasSegmentsTrait::class)]
class JsonSerializerTest extends EdiTestCase
{
    public function testSerialize997(): void
    {
        $serialize = new JsonSerializer();
        $edi = $this->createEdi997();

        $this->assertJsonStringEqualsJsonString($this->loadFixture('997.json'), $serialize->serialize($edi));
    }
}
