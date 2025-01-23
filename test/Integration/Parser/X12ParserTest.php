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
use Gtlogistics\EdiX12\Release\Loop\L5Loop2_204;
use Gtlogistics\EdiX12\Release\Loop\N1Loop1_204;
use Gtlogistics\EdiX12\Release\Loop\N1Loop2_204;
use Gtlogistics\EdiX12\Release\Loop\N7Loop1_204;
use Gtlogistics\EdiX12\Release\Loop\OIDLoop1_204;
use Gtlogistics\EdiX12\Release\Loop\S5Loop1_204;
use Gtlogistics\EdiX12\Release\Qualifier\ApplicationType;
use Gtlogistics\EdiX12\Release\Qualifier\CommunicationNumberQualifier;
use Gtlogistics\EdiX12\Release\Qualifier\ContactFunctionCode;
use Gtlogistics\EdiX12\Release\Qualifier\DateQualifier;
use Gtlogistics\EdiX12\Release\Qualifier\EntityIdentifierCode;
use Gtlogistics\EdiX12\Release\Qualifier\EquipmentDescriptionCode;
use Gtlogistics\EdiX12\Release\Qualifier\IdentificationCodeQualifier;
use Gtlogistics\EdiX12\Release\Qualifier\MarksAndNumbersQualifier;
use Gtlogistics\EdiX12\Release\Qualifier\ReferenceIdentificationQualifier;
use Gtlogistics\EdiX12\Release\Qualifier\RoutingSequenceCode;
use Gtlogistics\EdiX12\Release\Qualifier\ShipmentMethodOfPayment;
use Gtlogistics\EdiX12\Release\Qualifier\StopReasonCode;
use Gtlogistics\EdiX12\Release\Qualifier\TimeQualifier;
use Gtlogistics\EdiX12\Release\Qualifier\TransactionSetIdentifierCode;
use Gtlogistics\EdiX12\Release\Qualifier\TransactionSetPurposeCode;
use Gtlogistics\EdiX12\Release\Qualifier\TransportationMethodTypeCode;
use Gtlogistics\EdiX12\Release\Qualifier\UnitOrBasisForMeasurementCode;
use Gtlogistics\EdiX12\Release\Qualifier\WeightQualifier;
use Gtlogistics\EdiX12\Release\Qualifier\WeightUnitCode;
use Gtlogistics\EdiX12\Release\Release00401;
use Gtlogistics\EdiX12\Release\Segment\AT8Segment;
use Gtlogistics\EdiX12\Release\Segment\B2ASegment;
use Gtlogistics\EdiX12\Release\Segment\B2Segment;
use Gtlogistics\EdiX12\Release\Segment\G61Segment;
use Gtlogistics\EdiX12\Release\Segment\G62Segment;
use Gtlogistics\EdiX12\Release\Segment\L11Segment;
use Gtlogistics\EdiX12\Release\Segment\L3Segment;
use Gtlogistics\EdiX12\Release\Segment\L5Segment;
use Gtlogistics\EdiX12\Release\Segment\MS3Segment;
use Gtlogistics\EdiX12\Release\Segment\N1Segment;
use Gtlogistics\EdiX12\Release\Segment\N3Segment;
use Gtlogistics\EdiX12\Release\Segment\N4Segment;
use Gtlogistics\EdiX12\Release\Segment\N7Segment;
use Gtlogistics\EdiX12\Release\Segment\NTESegment;
use Gtlogistics\EdiX12\Release\Segment\OIDSegment;
use Gtlogistics\EdiX12\Release\Segment\S5Segment;
use Gtlogistics\EdiX12\Release\TransactionSet\TransactionSet204;
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

        $this->assertCount(1, $edi->ISA);
        $isa = $edi->ISA[0];
        $this->assertInstanceOf(IsaHeading::class, $isa);
        $this->assertSame('00', $isa->_01);
        $this->assertSame('          ', $isa->_02);
        $this->assertSame('00', $isa->_03);
        $this->assertSame('          ', $isa->_04);
        $this->assertSame('ZZ', $isa->_05);
        $this->assertSame('SENDER         ', $isa->_06);
        $this->assertSame('ZZ', $isa->_07);
        $this->assertSame('RECEIVER       ', $isa->_08);
        $this->assertDate('2024-01-31', $isa->_09);
        $this->assertTime('11:00:00.000', $isa->_10);
        $this->assertSame('U', $isa->_11);
        $this->assertSame('00401', $isa->_12);
        $this->assertSame(11111, $isa->_13);
        $this->assertSame('0', $isa->_14);
        $this->assertSame('P', $isa->_15);
        $this->assertSame('`', $isa->_16);

        $this->assertCount(1, $isa->GS);
        $gs = $isa->GS[0];
        $this->assertInstanceOf(GsHeading::class, $gs);
        $this->assertSame('SM', $gs->_01);
        $this->assertSame('SENDERAPP', $gs->_02);
        $this->assertSame('RECEIVERAPP', $gs->_03);
        $this->assertDate('2024-01-31', $gs->_04);
        $this->assertTime('11:00:00.000', $gs->_05);
        $this->assertSame(1000, $gs->_06);
        $this->assertSame('X', $gs->_07);
        $this->assertSame('004010', $gs->_08);

        $this->assertCount(1, $gs->ST);
        $st = $gs->ST[0];
        $this->assertInstanceOf(TransactionSet204::class, $st);
        $this->assertEnum(TransactionSetIdentifierCode::_204, $st->_01);
        $this->assertSame('1000', $st->_02);
        $this->assertNull($st->_03);

        $this->assertCount(1, $st->B2);
        $b2 = $st->B2[0];
        $this->assertInstanceOf(B2Segment::class, $b2);
        $this->assertNull($b2->_01);
        $this->assertSame('000X', $b2->_02);
        $this->assertNull($b2->_03);
        $this->assertSame('123456789', $b2->_04);
        $this->assertNull($b2->_05);
        $this->assertEnum(ShipmentMethodOfPayment::PP, $b2->_06);
        $this->assertNull($b2->_07);
        $this->assertNull($b2->_08);
        $this->assertNull($b2->_09);
        $this->assertNull($b2->_10);
        $this->assertNull($b2->_11);
        $this->assertNull($b2->_12);

        $this->assertCount(1, $st->B2A);
        $b2a = $st->B2A[0];
        $this->assertInstanceOf(B2ASegment::class, $b2a);
        $this->assertEnum(TransactionSetPurposeCode::_00, $b2a->_01);
        $this->assertEnum(ApplicationType::LT, $b2a->_02);

        $this->assertCount(2, $st->L11);
        $l11 = $st->L11[0];
        $this->assertInstanceOf(L11Segment::class, $l11);
        $this->assertSame('TRUCK 25 TON', $l11->_01);
        $this->assertEnum(ReferenceIdentificationQualifier::_6Y, $l11->_02);
        $this->assertNull($l11->_03);
        $l11 = $st->L11[1];
        $this->assertInstanceOf(L11Segment::class, $l11);
        $this->assertSame('SOLO', $l11->_01);
        $this->assertEnum(ReferenceIdentificationQualifier::MUTUALLY_DEFINED_ZZ, $l11->_02);
        $this->assertSame('12', $l11->_03);

        $this->assertCount(1, $st->G62);
        $g62 = $st->G62[0];
        $this->assertInstanceOf(G62Segment::class, $g62);
        $this->assertEnum(DateQualifier::_64, $g62->_01);
        $this->assertDate('2024-01-31', $g62->_02);
        $this->assertEnum(TimeQualifier::_1, $g62->_03);
        $this->assertTime('12:00:00.000', $g62->_04);
        $this->assertNull($g62->_05);

        $this->assertCount(1, $st->MS3);
        $ms3 = $st->MS3[0];
        $this->assertInstanceOf(MS3Segment::class, $ms3);
        $this->assertSame('000X', $ms3->_01);
        $this->assertEnum(RoutingSequenceCode::B, $ms3->_02);
        $this->assertNull($ms3->_03);
        $this->assertEnum(TransportationMethodTypeCode::M, $ms3->_04);
        $this->assertNull($ms3->_05);

        $this->assertCount(0, $st->AT5);
        $this->assertCount(0, $st->PLD);
        $this->assertCount(0, $st->LH6);

        $this->assertCount(3, $st->NTE);
        $this->assertNTE('Lorem ipsum dolor sit amet, consectetur adipiscing elit.', $st->NTE[0]);
        $this->assertNTE('Proin porta lectus eu faucibus aliquet.', $st->NTE[1]);
        $this->assertNTE('Nam pretium justo interdum, ultrices odio ac, blandit nulla.', $st->NTE[2]);

        $this->assertCount(3, $st->N1Loop1);
        $n1Loop = $st->N1Loop1[0];
        $this->assertInstanceOf(N1Loop1_204::class, $n1Loop);

        $this->assertCount(1, $n1Loop->N1);
        $n1 = $n1Loop->N1[0];
        $this->assertInstanceOf(N1Segment::class, $n1);
        $this->assertEnum(EntityIdentifierCode::OB, $n1->_01);
        $this->assertSame('Springfield Power Company', $n1->_02);
        $this->assertEnum(IdentificationCodeQualifier::ZZ, $n1->_03);
        $this->assertSame('XXXXXXXXXX', $n1->_04);
        $this->assertNull($n1->_05);

        $this->assertCount(0, $n1Loop->N2);

        $this->assertCount(1, $n1Loop->N3);
        $n3 = $n1Loop->N3[0];
        $this->assertInstanceOf(N3Segment::class, $n3);
        $this->assertSame('Evergreen Terrace', $n3->_01);
        $this->assertSame('742', $n3->_02);

        $this->assertCount(1, $n1Loop->N4);
        $n4 = $n1Loop->N4[0];
        $this->assertInstanceOf(N4Segment::class, $n4);
        $this->assertSame('Springfield', $n4->_01);
        $this->assertSame('OR', $n4->_02);
        $this->assertSame('80085', $n4->_03);
        $this->assertSame('USA', $n4->_04);
        $this->assertNull($n4->_05);
        $this->assertNull($n4->_06);

        $this->assertCount(0, $n1Loop->L11);

        $this->assertCount(1, $n1Loop->G61);
        $g61 = $n1Loop->G61[0];
        $this->assertInstanceOf(G61Segment::class, $g61);
        $this->assertEnum(ContactFunctionCode::OC, $g61->_01);
        $this->assertSame('Homer Simpson', $g61->_02);
        $this->assertEnum(CommunicationNumberQualifier::TE, $g61->_03);
        $this->assertSame('(939) 555-0113', $g61->_04);
        $this->assertNull($g61->_05);

        $n1Loop = $st->N1Loop1[1];
        $this->assertInstanceOf(N1Loop1_204::class, $n1Loop);

        $this->assertCount(1, $n1Loop->N1);
        $n1 = $n1Loop->N1[0];
        $this->assertInstanceOf(N1Segment::class, $n1);
        $this->assertEnum(EntityIdentifierCode::BT, $n1->_01);
        $this->assertSame('Springfield Power Company', $n1->_02);
        $this->assertEnum(IdentificationCodeQualifier::ZZ, $n1->_03);
        $this->assertSame('ZZ', $n1->_04);
        $this->assertNull($n1->_05);

        $this->assertCount(0, $n1Loop->N2);

        $this->assertCount(1, $n1Loop->N3);
        $n3 = $n1Loop->N3[0];
        $this->assertInstanceOf(N3Segment::class, $n3);
        $this->assertSame('Fake Street', $n3->_01);
        $this->assertSame('123', $n3->_02);

        $this->assertCount(1, $n1Loop->N4);
        $n4 = $n1Loop->N4[0];
        $this->assertInstanceOf(N4Segment::class, $n4);
        $this->assertSame('Springfield', $n4->_01);
        $this->assertSame('OR', $n4->_02);
        $this->assertSame('80085', $n4->_03);
        $this->assertSame('USA', $n4->_04);
        $this->assertNull($n4->_05);
        $this->assertNull($n4->_06);

        $this->assertCount(0, $n1Loop->L11);
        $this->assertCount(0, $n1Loop->G61);

        $n1Loop = $st->N1Loop1[2];
        $this->assertInstanceOf(N1Loop1_204::class, $n1Loop);

        $this->assertCount(1, $n1Loop->N1);
        $n1 = $n1Loop->N1[0];
        $this->assertInstanceOf(N1Segment::class, $n1);
        $this->assertEnum(EntityIdentifierCode::BN, $n1->_01);
        $this->assertSame('Charles Montgomery Burns', $n1->_02);
        $this->assertNull($n1->_03);
        $this->assertNull($n1->_04);
        $this->assertNull($n1->_05);

        $this->assertCount(0, $n1Loop->N2);
        $this->assertCount(0, $n1Loop->N3);
        $this->assertCount(0, $n1Loop->N4);
        $this->assertCount(0, $n1Loop->L11);
        $this->assertCount(0, $n1Loop->G61);

        $this->assertCount(1, $st->N7Loop1);
        $n7Loop = $st->N7Loop1[0];
        $this->assertInstanceOf(N7Loop1_204::class, $n7Loop);

        $this->assertCount(1, $n7Loop->N7);
        $n7 = $n7Loop->N7[0];
        $this->assertInstanceOf(N7Segment::class, $n7);
        $this->assertNull($n7->_01);
        $this->assertSame('000000', $n7->_02);
        $this->assertNull($n7->_03);
        $this->assertNull($n7->_04);
        $this->assertNull($n7->_05);
        $this->assertNull($n7->_06);
        $this->assertNull($n7->_07);
        $this->assertNull($n7->_08);
        $this->assertNull($n7->_09);
        $this->assertNull($n7->_10);
        $this->assertEnum(EquipmentDescriptionCode::TV, $n7->_11);
        $this->assertNull($n7->_12);
        $this->assertNull($n7->_13);
        $this->assertNull($n7->_14);
        $this->assertSame(5000, $n7->_15);
        $this->assertNull($n7->_16);
        $this->assertNull($n7->_17);
        $this->assertNull($n7->_18);
        $this->assertNull($n7->_19);
        $this->assertNull($n7->_20);
        $this->assertNull($n7->_21);
        $this->assertSame('XXXX', $n7->_22);
        $this->assertNull($n7->_23);
        $this->assertNull($n7->_24);

        $this->assertCount(0, $n7Loop->N7A);
        $this->assertCount(0, $n7Loop->N7B);
        $this->assertCount(0, $n7Loop->MEA);
        $this->assertCount(0, $n7Loop->M7);

        $this->assertCount(2, $st->S5Loop1);
        $s5Loop = $st->S5Loop1[0];
        $this->assertInstanceOf(S5Loop1_204::class, $s5Loop);

        $this->assertCount(1, $s5Loop->S5);
        $s5 = $s5Loop->S5[0];
        $this->assertInstanceOf(S5Segment::class, $s5);
        $this->assertSame(1, $s5->_01);
        $this->assertEnum(StopReasonCode::CL, $s5->_02);
        $this->assertSame(5432.1, $s5->_03);
        $this->assertEnum(WeightUnitCode::K, $s5->_04);
        $this->assertSame(100.0, $s5->_05);
        $this->assertEnum(UnitOrBasisForMeasurementCode::PC, $s5->_06);
        $this->assertNull($s5->_07);
        $this->assertNull($s5->_08);
        $this->assertNull($s5->_09);
        $this->assertNull($s5->_10);
        $this->assertNull($s5->_11);

        $this->assertCount(2, $s5Loop->L11);
        $l11 = $s5Loop->L11[0];
        $this->assertInstanceOf(L11Segment::class, $l11);
        $this->assertSame('11111', $l11->_01);
        $this->assertEnum(ReferenceIdentificationQualifier::OQ, $l11->_02);
        $this->assertNull($l11->_03);
        $l11 = $s5Loop->L11[1];
        $this->assertInstanceOf(L11Segment::class, $l11);
        $this->assertSame('22222', $l11->_01);
        $this->assertEnum(ReferenceIdentificationQualifier::KK, $l11->_02);
        $this->assertNull($l11->_03);

        $this->assertCount(2, $s5Loop->G62);
        $g62 = $s5Loop->G62[0];
        $this->assertInstanceOf(G62Segment::class, $g62);
        $this->assertEnum(DateQualifier::_37, $g62->_01);
        $this->assertDate('2024-01-31', $g62->_02);
        $this->assertEnum(TimeQualifier::I, $g62->_03);
        $this->assertTime('08:00:00.000', $g62->_04);
        $this->assertNull($g62->_05);
        $g62 = $s5Loop->G62[1];
        $this->assertInstanceOf(G62Segment::class, $g62);
        $this->assertEnum(DateQualifier::_38, $g62->_01);
        $this->assertDate('2024-01-31', $g62->_02);
        $this->assertEnum(TimeQualifier::K, $g62->_03);
        $this->assertTime('14:00:00.000', $g62->_04);
        $this->assertNull($g62->_05);

        $this->assertCount(1, $s5Loop->AT8);
        $at8 = $s5Loop->AT8[0];
        $this->assertInstanceOf(AT8Segment::class, $at8);
        $this->assertEnum(WeightQualifier::G, $at8->_01);
        $this->assertEnum(WeightUnitCode::K, $at8->_02);
        $this->assertSame(5432.1, $at8->_03);
        $this->assertSame(100, $at8->_04);
        $this->assertNull($at8->_05);
        $this->assertNull($at8->_06);
        $this->assertNull($at8->_07);

        $this->assertCount(0, $s5Loop->LAD);
        $this->assertCount(0, $s5Loop->AT5);
        $this->assertCount(0, $s5Loop->PLD);
        $this->assertCount(0, $s5Loop->NTE);

        $this->assertCount(1, $s5Loop->N1Loop2);
        $n1Loop = $s5Loop->N1Loop2[0];
        $this->assertInstanceOf(N1Loop2_204::class, $n1Loop);

        $this->assertCount(1, $n1Loop->N1);
        $n1 = $n1Loop->N1[0];
        $this->assertInstanceOf(N1Segment::class, $n1);
        $this->assertEnum(EntityIdentifierCode::SF, $n1->_01);
        $this->assertSame('Bednar LLC', $n1->_02);
        $this->assertEnum(IdentificationCodeQualifier::ZZ, $n1->_03);
        $this->assertSame($n1->_04, 'XXXX');
        $this->assertNull($n1->_05);

        $this->assertCount(0, $n1Loop->N2);

        $this->assertCount(1, $n1Loop->N3);
        $n3 = $n1Loop->N3[0];
        $this->assertInstanceOf(N3Segment::class, $n3);
        $this->assertSame('927 Washington Boulevard', $n3->_01);
        $this->assertNull($n3->_02);

        $this->assertCount(1, $n1Loop->N4);
        $n4 = $n1Loop->N4[0];
        $this->assertInstanceOf(N4Segment::class, $n4);
        $this->assertSame('Newport', $n4->_01);
        $this->assertSame('RI', $n4->_02);
        $this->assertSame('02840', $n4->_03);
        $this->assertSame('USA', $n4->_04);
        $this->assertNull($n4->_05);
        $this->assertNull($n4->_06);

        $this->assertCount(1, $n1Loop->G61);
        $g61 = $n1Loop->G61[0];
        $this->assertInstanceOf(G61Segment::class, $g61);
        $this->assertEnum(ContactFunctionCode::SH, $g61->_01);
        $this->assertSame('UNKNOWN', $g61->_02);
        $this->assertEnum(CommunicationNumberQualifier::TE, $g61->_03);
        $this->assertSame('555-555-5555', $g61->_04);
        $this->assertNull($g61->_05);

        $this->assertCount(0, $s5Loop->L5Loop1);

        $this->assertCount(1, $s5Loop->OIDLoop1);
        $oidLoop = $s5Loop->OIDLoop1[0];
        $this->assertInstanceOf(OIDLoop1_204::class, $oidLoop);

        $this->assertCount(1, $oidLoop->OID);
        $oid = $oidLoop->OID[0];
        $this->assertInstanceOf(OIDSegment::class, $oid);
        $this->assertSame('S1', $oid->_01);
        $this->assertSame('0123456789', $oid->_02);
        $this->assertNull($oid->_03);
        $this->assertEnum(UnitOrBasisForMeasurementCode::PC, $oid->_04);
        $this->assertSame(100.0, $oid->_05);
        $this->assertEnum(WeightUnitCode::K, $oid->_06);
        $this->assertSame(5432.1, $oid->_07);
        $this->assertNull($oid->_08);
        $this->assertNull($oid->_09);

        $this->assertCount(0, $oidLoop->G62);
        $this->assertCount(0, $oidLoop->LAD);

        $this->assertCount(1, $oidLoop->L5Loop2);
        $l5Loop = $oidLoop->L5Loop2[0];
        $this->assertInstanceOf(L5Loop2_204::class, $l5Loop);

        $this->assertCount(1, $l5Loop->L5);
        $l5 = $l5Loop->L5[0];
        $this->assertInstanceOf(L5Segment::class, $l5);
        $this->assertSame(1, $l5->_01);
        $this->assertSame('Chair', $l5->_02);
        $this->assertNull($l5->_03);
        $this->assertNull($l5->_04);
        $this->assertNull($l5->_05);
        $this->assertSame('000000000987654321', $l5->_06);
        $this->assertEnum(MarksAndNumbersQualifier::SM, $l5->_07);
        $this->assertNull($l5->_08);
        $this->assertNull($l5->_09);
        $this->assertNull($l5->_10);

        $this->assertCount(1, $l5Loop->AT8);
        $at8 = $l5Loop->AT8[0];
        $this->assertInstanceOf(AT8Segment::class, $at8);
        $this->assertEnum(WeightQualifier::G, $at8->_01);
        $this->assertEnum(WeightUnitCode::K, $at8->_02);
        $this->assertSame(5432.1, $at8->_03);
        $this->assertSame(100, $at8->_04);
        $this->assertSame(10, $at8->_05);
        $this->assertNull($at8->_06);
        $this->assertNull($at8->_07);

        $this->assertCount(0, $l5Loop->G61Loop2);

        $s5Loop = $st->S5Loop1[1];
        $this->assertInstanceOf(S5Loop1_204::class, $s5Loop);

        $this->assertCount(1, $s5Loop->S5);
        $s5 = $s5Loop->S5[0];
        $this->assertInstanceOf(S5Segment::class, $s5);
        $this->assertSame(99, $s5->_01);
        $this->assertEnum(StopReasonCode::CU, $s5->_02);
        $this->assertSame(5432.1, $s5->_03);
        $this->assertEnum(WeightUnitCode::K, $s5->_04);
        $this->assertSame(100.0, $s5->_05);
        $this->assertEnum(UnitOrBasisForMeasurementCode::PC, $s5->_06);
        $this->assertNull($s5->_07);
        $this->assertNull($s5->_08);
        $this->assertNull($s5->_09);
        $this->assertNull($s5->_10);
        $this->assertNull($s5->_11);

        $this->assertCount(2, $s5Loop->L11);
        $l11 = $s5Loop->L11[0];
        $this->assertInstanceOf(L11Segment::class, $l11);
        $this->assertSame('33333', $l11->_01);
        $this->assertSame(ReferenceIdentificationQualifier::OQ, $l11->_02);
        $this->assertNull($l11->_03);

        $l11 = $s5Loop->L11[1];
        $this->assertInstanceOf(L11Segment::class, $l11);
        $this->assertSame('44444', $l11->_01);
        $this->assertSame(ReferenceIdentificationQualifier::KK, $l11->_02);
        $this->assertNull($l11->_03);

        $this->assertCount(1, $s5Loop->G62);
        $g62 = $s5Loop->G62[0];
        $this->assertInstanceOf(G62Segment::class, $g62);
        $this->assertEnum(DateQualifier::_02, $g62->_01);
        $this->assertDate('2024-02-05', $g62->_02);
        $this->assertEnum(TimeQualifier::Z, $g62->_03);
        $this->assertTime('11:00:00.000', $g62->_04);
        $this->assertNull($g62->_05);

        $this->assertCount(1, $s5Loop->AT8);
        $at8 = $s5Loop->AT8[0];
        $this->assertInstanceOf(AT8Segment::class, $at8);
        $this->assertEnum(WeightQualifier::G, $at8->_01);
        $this->assertEnum(WeightUnitCode::K, $at8->_02);
        $this->assertSame(5432.1, $at8->_03);
        $this->assertSame(100, $at8->_04);
        $this->assertNull($at8->_05);
        $this->assertNull($at8->_06);
        $this->assertNull($at8->_07);

        $this->assertCount(0, $s5Loop->LAD);
        $this->assertCount(0, $s5Loop->AT5);
        $this->assertCount(0, $s5Loop->PLD);
        $this->assertCount(0, $s5Loop->NTE);

        $this->assertCount(1, $s5Loop->N1Loop2);
        $n1Loop = $s5Loop->N1Loop2[0];
        $this->assertInstanceOf(N1Loop2_204::class, $n1Loop);

        $this->assertCount(1, $n1Loop->N1);
        $n1 = $n1Loop->N1[0];
        $this->assertSame(EntityIdentifierCode::CN, $n1->_01);
        $this->assertSame('Springfield Power Company', $n1->_02);
        $this->assertSame(IdentificationCodeQualifier::ZZ, $n1->_03);
        $this->assertSame('ZZZZ', $n1->_04);

        $this->assertCount(0, $n1Loop->N2);

        $this->assertCount(1, $n1Loop->N3);
        $n3 = $n1Loop->N3[0];
        $this->assertInstanceOf(N3Segment::class, $n3);
        $this->assertSame('Fake Street 123', $n3->_01);
        $this->assertNull($n3->_02);

        $this->assertCount(1, $n1Loop->N4);
        $n4 = $n1Loop->N4[0];
        $this->assertInstanceOf(N4Segment::class, $n4);
        $this->assertSame('Springfield', $n4->_01);
        $this->assertSame('OR', $n4->_02);
        $this->assertSame('80085', $n4->_03);
        $this->assertSame('USA', $n4->_04);
        $this->assertNull($n4->_05);
        $this->assertNull($n4->_06);

        $this->assertCount(1, $n1Loop->G61);
        $g61 = $n1Loop->G61[0];
        $this->assertInstanceOf(G61Segment::class, $g61);
        $this->assertEnum(ContactFunctionCode::DC, $g61->_01);
        $this->assertSame('Unknown', $g61->_02);
        $this->assertEnum(CommunicationNumberQualifier::TE, $g61->_03);
        $this->assertSame('555-555-1212', $g61->_04);
        $this->assertNull($g61->_05);

        $this->assertCount(0, $s5Loop->L5Loop1);

        $this->assertCount(1, $s5Loop->OIDLoop1);
        $oidLoop = $s5Loop->OIDLoop1[0];
        $this->assertInstanceOf(OIDLoop1_204::class, $oidLoop);

        $this->assertCount(1, $oidLoop->OID);
        $oid = $oidLoop->OID[0];
        $this->assertInstanceOf(OIDSegment::class, $oid);
        $this->assertSame('S1', $oid->_01);
        $this->assertSame('0123456789', $oid->_02);
        $this->assertNull($oid->_03);
        $this->assertEnum(UnitOrBasisForMeasurementCode::PC, $oid->_04);
        $this->assertSame(100.0, $oid->_05);
        $this->assertEnum(WeightUnitCode::K, $oid->_06);
        $this->assertSame(5432.1, $oid->_07);
        $this->assertNull($oid->_08);
        $this->assertNull($oid->_09);

        $this->assertCount(0, $oidLoop->G62);
        $this->assertCount(0, $oidLoop->LAD);

        $this->assertCount(1, $oidLoop->L5Loop2);
        $l5Loop = $oidLoop->L5Loop2[0];
        $this->assertInstanceOf(L5Loop2_204::class, $l5Loop);

        $this->assertCount(1, $l5Loop->L5);
        $l5 = $l5Loop->L5[0];
        $this->assertInstanceOf(L5Segment::class, $l5);
        $this->assertSame(1, $l5->_01);
        $this->assertSame('Chair', $l5->_02);
        $this->assertNull($l5->_03);
        $this->assertNull($l5->_04);
        $this->assertNull($l5->_05);
        $this->assertSame('000000000987654321', $l5->_06);
        $this->assertEnum(MarksAndNumbersQualifier::SM, $l5->_07);
        $this->assertNull($l5->_08);
        $this->assertNull($l5->_09);
        $this->assertNull($l5->_10);

        $this->assertCount(1, $l5Loop->AT8);
        $at8 = $l5Loop->AT8[0];
        $this->assertInstanceOf(AT8Segment::class, $at8);
        $this->assertEnum(WeightQualifier::G, $at8->_01);
        $this->assertEnum(WeightUnitCode::K, $at8->_02);
        $this->assertSame(5432.1, $at8->_03);
        $this->assertSame(100, $at8->_04);
        $this->assertSame(10, $at8->_05);
        $this->assertNull($at8->_06);
        $this->assertNull($at8->_07);

        $this->assertCount(0, $l5Loop->G61Loop2);

        $this->assertCount(1, $st->L3);
        $l3 = $st->L3[0];
        $this->assertInstanceOf(L3Segment::class, $l3);
        $this->assertSame(5432.1, $l3->_01);
        $this->assertSame(WeightQualifier::N, $l3->_02);
        $this->assertNull($l3->_03);
        $this->assertNull($l3->_04);
        $this->assertSame(100, $l3->_05);
        $this->assertNull($l3->_06);
        $this->assertNull($l3->_07);
        $this->assertNull($l3->_08);
        $this->assertNull($l3->_09);
        $this->assertNull($l3->_10);
        $this->assertSame(100, $l3->_11);
        $this->assertEnum(WeightUnitCode::K, $l3->_12);
        $this->assertNull($l3->_13);
        $this->assertNull($l3->_14);
        $this->assertNull($l3->_15);
    }

    private function assertNTE(string $expected, mixed $item): void
    {
        $this->assertInstanceOf(NTESegment::class, $item);
        $this->assertNull($item->_01);
        $this->assertSame($expected, $item->_02);
    }
}
