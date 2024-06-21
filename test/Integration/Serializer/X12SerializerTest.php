<?php

namespace Gtlogistics\X12Parser\Test\Integration\Parser;

use Gtlogistics\X12Parser\Edi;
use Gtlogistics\X12Parser\Heading\GsHeading;
use Gtlogistics\X12Parser\Heading\IsaHeading;
use Gtlogistics\X12Parser\Model\AbstractSegment;
use Gtlogistics\X12Parser\Model\AbstractTransactionSet;
use Gtlogistics\X12Parser\Model\HasSegmentsTrait;
use Gtlogistics\X12Parser\Release\Qualifier\FunctionalGroupAcknowledgeCode;
use Gtlogistics\X12Parser\Release\Qualifier\FunctionalIdentifierCode;
use Gtlogistics\X12Parser\Release\Qualifier\TransactionSetIdentifierCode;
use Gtlogistics\X12Parser\Release\Segment\AK1Segment;
use Gtlogistics\X12Parser\Release\Segment\AK9Segment;
use Gtlogistics\X12Parser\Release\TransactionSet\TransactionSet997;
use Gtlogistics\X12Parser\Serializer\X12Serializer;
use Gtlogistics\X12Parser\Test\EdiTestCase;
use Gtlogistics\X12Parser\Trailer\GeTrailer;
use Gtlogistics\X12Parser\Trailer\IeaTrailer;
use Gtlogistics\X12Parser\Trailer\SeTrailer;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversTrait;

#[CoversClass(X12Serializer::class)]
#[CoversClass(Edi::class)]
#[CoversClass(GsHeading::class)]
#[CoversClass(GeTrailer::class)]
#[CoversClass(IsaHeading::class)]
#[CoversClass(IeaTrailer::class)]
#[CoversClass(SeTrailer::class)]
#[CoversClass(AbstractTransactionSet::class)]
#[CoversClass(AbstractSegment::class)]
#[CoversTrait(HasSegmentsTrait::class)]
class X12SerializerTest extends EdiTestCase
{
    public function testSerialize997(): void
    {
        $dateTime = new \DateTimeImmutable('2024-01-31 11:00:00');
        $serialize = new X12Serializer('*', '~');

        $ak1 = new AK1Segment();
        $ak1->_01 = FunctionalIdentifierCode::MOTOR_CARRIER_LOAD_TENDER204;
        $ak1->_02 = 1;

        $ak9 = new AK9Segment();
        $ak9->_01 = FunctionalGroupAcknowledgeCode::ACCEPTED;
        $ak9->_02 = 1;
        $ak9->_03 = 1;
        $ak9->_04 = 1;

        $st = new TransactionSet997();
        $st->_01 = TransactionSetIdentifierCode::FUNCTIONAL_ACKNOWLEDGMENT;
        $st->_02 = '1000';
        $st->AK1[] = $ak1;
        $st->AK9[] = $ak9;

        $gs = new GsHeading();
        $gs->_01 = 'FA';
        $gs->_02 = 'SENDERAPP';
        $gs->_03 = 'RECEIVERAPP';
        $gs->_04 = $dateTime;
        $gs->_05 = $dateTime;
        $gs->_06 = 100;
        $gs->_07 = 'X';
        $gs->_08 = '004010';
        $gs->ST[] = $st;

        $isa = new IsaHeading();
        $isa->_01 = '00';
        $isa->_03 = '00';
        $isa->_05 = 'ZZ';
        $isa->_06 = 'SENDER';
        $isa->_07 = 'ZZ';
        $isa->_08 = 'RECEIVER';
        $isa->_09 = $dateTime;
        $isa->_10 = $dateTime;
        $isa->_11 = 'U';
        $isa->_12 = '00401';
        $isa->_13 = 10;
        $isa->_14 = '0';
        $isa->_15 = 'P';
        $isa->_16 = '`';
        $isa->GS[] = $gs;

        $edi = new Edi();
        $edi->ISA[] = $isa;

        $this->assertEdi($this->loadFixture('997.edi'), $serialize->serialize($edi));
    }
}
