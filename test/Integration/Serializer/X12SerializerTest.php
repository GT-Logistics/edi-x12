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
use Gtlogistics\EdiX12\Model\AbstractSegment;
use Gtlogistics\EdiX12\Model\AbstractTransactionSet;
use Gtlogistics\EdiX12\Model\HasSegmentsTrait;
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
use Gtlogistics\EdiX12\Release\Qualifier\FunctionalGroupAcknowledgeCode;
use Gtlogistics\EdiX12\Release\Qualifier\FunctionalIdentifierCode;
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
use Gtlogistics\EdiX12\Release\Segment\AK1Segment;
use Gtlogistics\EdiX12\Release\Segment\AK9Segment;
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
use Gtlogistics\EdiX12\Release\TransactionSet\TransactionSet997;
use Gtlogistics\EdiX12\Serializer\X12Serializer;
use Gtlogistics\EdiX12\Test\EdiTestCase;
use Gtlogistics\EdiX12\Trailer\GeTrailer;
use Gtlogistics\EdiX12\Trailer\IeaTrailer;
use Gtlogistics\EdiX12\Trailer\SeTrailer;
use Gtlogistics\EdiX12\Util\EdiUtils;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversTrait;

#[CoversClass(X12Serializer::class)]
#[CoversClass(EdiUtils::class)]
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
    public function testSerialize204(): void
    {
        $dateTime = new \DateTimeImmutable('2024-01-31 11:00:00');
        $serialize = new X12Serializer('*', '~');

        $edi = new Edi();

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
        $isa->_13 = 11111;
        $isa->_14 = '0';
        $isa->_15 = 'P';
        $isa->_16 = '`';
        $edi->ISA[] = $isa;

        $gs = new GsHeading();
        $gs->_01 = 'SM';
        $gs->_02 = 'SENDERAPP';
        $gs->_03 = 'RECEIVERAPP';
        $gs->_04 = $dateTime;
        $gs->_05 = $dateTime;
        $gs->_06 = 1000;
        $gs->_07 = 'X';
        $gs->_08 = '004010';
        $isa->GS[] = $gs;

        $st = new TransactionSet204();
        $st->_01 = TransactionSetIdentifierCode::_204;
        $st->_02 = '1000';
        $gs->ST[] = $st;

        $b2 = new B2Segment();
        $b2->_02 = '000X';
        $b2->_04 = '123456789';
        $b2->_06 = ShipmentMethodOfPayment::PP;
        $st->B2[] = $b2;

        $b2a = new B2ASegment();
        $b2a->_01 = TransactionSetPurposeCode::_00;
        $b2a->_02 = ApplicationType::LT;
        $st->B2A[] = $b2a;

        $l11 = new L11Segment();
        $l11->_01 = 'TRUCK 25 TON';
        $l11->_02 = ReferenceIdentificationQualifier::_6Y;
        $st->L11[] = $l11;

        $l11 = new L11Segment();
        $l11->_01 = 'SOLO';
        $l11->_02 = ReferenceIdentificationQualifier::ZZ;
        $l11->_03 = '12';
        $st->L11[] = $l11;

        $g62 = new G62Segment();
        $g62->_01 = DateQualifier::_64;
        $g62->_02 = new \DateTimeImmutable('2024-01-31');
        $g62->_03 = TimeQualifier::_1;
        $g62->_04 = new \DateTimeImmutable('12:00');
        $st->G62[] = $g62;

        $ms3 = new Ms3Segment();
        $ms3->_01 = '000X';
        $ms3->_02 = RoutingSequenceCode::B;
        $ms3->_04 = TransportationMethodTypeCode::M;
        $st->MS3[] = $ms3;

        $nte = new NteSegment();
        $nte->_02 = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.';
        $st->NTE[] = $nte;

        $nte = new NteSegment();
        $nte->_02 = 'Proin porta lectus eu faucibus aliquet.';
        $st->NTE[] = $nte;

        $nte = new NteSegment();
        $nte->_02 = 'Nam pretium justo interdum, ultrices odio ac, blandit nulla.';
        $st->NTE[] = $nte;

        $n1Loop = new N1Loop1_204();
        $st->N1Loop1[] = $n1Loop;

        $n1 = new N1Segment();
        $n1->_01 = EntityIdentifierCode::OB;
        $n1->_02 = 'Springfield Power Company';
        $n1->_03 = IdentificationCodeQualifier::ZZ;
        $n1->_04 = 'XXXXXXXXXX';
        $n1Loop->N1[] = $n1;

        $n3 = new N3Segment();
        $n3->_01 = 'Evergreen Terrace';
        $n3->_02 = '742';
        $n1Loop->N3[] = $n3;

        $n4 = new N4Segment();
        $n4->_01 = 'Springfield';
        $n4->_02 = 'OR';
        $n4->_03 = '80085';
        $n4->_04 = 'USA';
        $n1Loop->N4[] = $n4;

        $g61 = new G61Segment();
        $g61->_01 = ContactFunctionCode::OC;
        $g61->_02 = 'Homer Simpson';
        $g61->_03 = CommunicationNumberQualifier::TE;
        $g61->_04 = '(939) 555-0113';
        $n1Loop->G61[] = $g61;

        $n1Loop = new N1Loop1_204();
        $st->N1Loop1[] = $n1Loop;

        $n1 = new N1Segment();
        $n1->_01 = EntityIdentifierCode::BT;
        $n1->_02 = 'Springfield Power Company';
        $n1->_03 = IdentificationCodeQualifier::ZZ;
        $n1->_04 = 'XXXXXXXXXX';
        $n1Loop->N1[] = $n1;

        $n3 = new N3Segment();
        $n3->_01 = 'Evergreen Terrace';
        $n3->_02 = '742';
        $n1Loop->N3[] = $n3;

        $n4 = new N4Segment();
        $n4->_01 = 'Springfield';
        $n4->_02 = 'OR';
        $n4->_03 = '80085';
        $n4->_04 = 'USA';
        $n1Loop->N4[] = $n4;

        $n1Loop = new N1Loop1_204();
        $st->N1Loop1[] = $n1Loop;

        $n1 = new N1Segment();
        $n1->_01 = EntityIdentifierCode::BN;
        $n1->_02 = 'Charles Montgomery Burns';
        $n1Loop->N1[] = $n1;

        $n7Loop = new N7Loop1_204();
        $st->N7Loop1[] = $n7Loop;

        $n7 = new N7Segment();
        $n7->_02 = '000000';
        $n7->_11 = EquipmentDescriptionCode::TV;
        $n7->_15 = 5000;
        $n7->_22 = 'XXXX';
        $n7Loop->N7[] = $n7;

        $s5Loop = new S5Loop1_204();
        $st->S5Loop1[] = $s5Loop;

        $s5 = new S5Segment();
        $s5->_01 = 1;
        $s5->_02 = StopReasonCode::CL;
        $s5->_03 = 5432.1;
        $s5->_04 = WeightUnitCode::K;
        $s5->_05 = 100.0;
        $s5->_06 = UnitOrBasisForMeasurementCode::PC;
        $s5Loop->S5[] = $s5;

        $l11 = new L11Segment();
        $l11->_01 = '11111';
        $l11->_02 = ReferenceIdentificationQualifier::OQ;
        $s5Loop->L11[] = $l11;

        $l11 = new L11Segment();
        $l11->_01 = '22222';
        $l11->_02 = ReferenceIdentificationQualifier::KK;
        $s5Loop->L11[] = $l11;

        $g62 = new G62Segment();
        $g62->_01 = DateQualifier::_37;
        $g62->_02 = new \DateTimeImmutable('2024-01-31');
        $g62->_03 = TimeQualifier::I;
        $g62->_04 = new \DateTimeImmutable('08:00');
        $s5Loop->G62[] = $g62;

        $g62 = new G62Segment();
        $g62->_01 = DateQualifier::_38;
        $g62->_02 = new \DateTimeImmutable('2024-01-31');
        $g62->_03 = TimeQualifier::K;
        $g62->_04 = new \DateTimeImmutable('14:00');
        $s5Loop->G62[] = $g62;

        $at8 = new AT8Segment();
        $at8->_01 = WeightQualifier::G;
        $at8->_02 = WeightUnitCode::K;
        $at8->_03 = 5432.1;
        $at8->_04 = 100;
        $s5Loop->AT8[] = $at8;

        $n1Loop = new N1Loop2_204();
        $s5Loop->N1Loop2[] = $n1Loop;

        $n1 = new N1Segment();
        $n1->_01 = EntityIdentifierCode::SF;
        $n1->_02 = 'Bednar LLC';
        $n1->_03 = IdentificationCodeQualifier::ZZ;
        $n1->_04 = 'ZZZZ';
        $n1Loop->N1[] = $n1;

        $n3 = new N3Segment();
        $n3->_01 = '927 Washington Boulevard';
        $n1Loop->N3[] = $n3;

        $n4 = new N4Segment();
        $n4->_01 = 'Newport';
        $n4->_02 = 'RI';
        $n4->_03 = '02840';
        $n4->_04 = 'USA';
        $n1Loop->N4[] = $n4;

        $g61 = new G61Segment();
        $g61->_01 = ContactFunctionCode::SH;
        $g61->_02 = 'UNKNOWN';
        $g61->_03 = CommunicationNumberQualifier::TE;
        $g61->_04 = '555-555-5555';
        $n1Loop->G61[] = $g61;

        $oidLoop = new OIDLoop1_204();
        $s5Loop->OIDLoop1[] = $oidLoop;

        $oid = new OIDSegment();
        $oid->_01 = 'S1';
        $oid->_02 = '0123456789';
        $oid->_04 = UnitOrBasisForMeasurementCode::PC;
        $oid->_05 = 100.0;
        $oid->_06 = WeightUnitCode::K;
        $oid->_07 = 5432.1;
        $oidLoop->OID[] = $oid;

        $l5Loop = new L5Loop2_204();
        $oidLoop->L5Loop2[] = $l5Loop;

        $l5 = new L5Segment();
        $l5->_01 = 1;
        $l5->_02 = 'Chair';
        $l5->_06 = '000000000987654321';
        $l5->_07 = MarksAndNumbersQualifier::SM;
        $l5Loop->L5[] = $l5;

        $at8 = new AT8Segment();
        $at8->_01 = WeightQualifier::G;
        $at8->_02 = WeightUnitCode::K;
        $at8->_03 = 5432.1;
        $at8->_04 = 100;
        $at8->_05 = 10;
        $l5Loop->AT8[] = $at8;

        $s5Loop = new S5Loop1_204();
        $st->S5Loop1[] = $s5Loop;

        $s5 = new S5Segment();
        $s5->_01 = 99;
        $s5->_02 = StopReasonCode::CU;
        $s5->_03 = 5432.1;
        $s5->_04 = WeightUnitCode::K;
        $s5->_05 = 100.0;
        $s5->_06 = UnitOrBasisForMeasurementCode::PC;
        $s5Loop->S5[] = $s5;

        $l11 = new L11Segment();
        $l11->_01 = '33333';
        $l11->_02 = ReferenceIdentificationQualifier::OQ;
        $s5Loop->L11[] = $l11;

        $l11 = new L11Segment();
        $l11->_01 = '44444';
        $l11->_02 = ReferenceIdentificationQualifier::KK;
        $s5Loop->L11[] = $l11;

        $g62 = new G62Segment();
        $g62->_01 = DateQualifier::_02;
        $g62->_02 = new \DateTimeImmutable('2024-02-05');
        $g62->_03 = TimeQualifier::Z;
        $g62->_04 = new \DateTimeImmutable('11:00');
        $s5Loop->G62[] = $g62;

        $at8 = new AT8Segment();
        $at8->_01 = WeightQualifier::G;
        $at8->_02 = WeightUnitCode::K;
        $at8->_03 = 5432.1;
        $at8->_04 = 100;
        $s5Loop->AT8[] = $at8;

        $n1Loop = new N1Loop2_204();
        $s5Loop->N1Loop2[] = $n1Loop;

        $n1 = new N1Segment();
        $n1->_01 = EntityIdentifierCode::CN;
        $n1->_02 = 'Springfield Power Company';
        $n1->_03 = IdentificationCodeQualifier::ZZ;
        $n1->_04 = 'XXXX';
        $n1Loop->N1[] = $n1;

        $n3 = new N3Segment();
        $n3->_01 = 'Evergreen Terrace';
        $n3->_02 = '742';
        $n1Loop->N3[] = $n3;

        $n4 = new N4Segment();
        $n4->_01 = 'Springfield';
        $n4->_02 = 'OR';
        $n4->_03 = '80085';
        $n4->_04 = 'USA';
        $n1Loop->N4[] = $n4;

        $g61 = new G61Segment();
        $g61->_01 = ContactFunctionCode::DC;
        $g61->_02 = 'Homer Simpson';
        $g61->_03 = CommunicationNumberQualifier::TE;
        $g61->_04 = '(939) 555-0113';
        $n1Loop->G61[] = $g61;

        $oidLoop = new OIDLoop1_204();
        $s5Loop->OIDLoop1[] = $oidLoop;

        $oid = new OIDSegment();
        $oid->_01 = 'S1';
        $oid->_02 = '0123456789';
        $oid->_04 = UnitOrBasisForMeasurementCode::PC;
        $oid->_05 = 100.0;
        $oid->_06 = WeightUnitCode::K;
        $oid->_07 = 5432.1;
        $oidLoop->OID[] = $oid;

        $l5Loop = new L5Loop2_204();
        $oidLoop->L5Loop2[] = $l5Loop;

        $l5 = new L5Segment();
        $l5->_01 = 1;
        $l5->_02 = 'Chair';
        $l5->_06 = '000000000987654321';
        $l5->_07 = MarksAndNumbersQualifier::SM;
        $l5Loop->L5[] = $l5;

        $at8 = new AT8Segment();
        $at8->_01 = WeightQualifier::G;
        $at8->_02 = WeightUnitCode::K;
        $at8->_03 = 5432.1;
        $at8->_04 = 100;
        $at8->_05 = 10;
        $l5Loop->AT8[] = $at8;

        $l3 = new L3Segment();
        $l3->_01 = 5432.1;
        $l3->_02 = WeightQualifier::N;
        $l3->_05 = 100;
        $l3->_11 = 100;
        $l3->_12 = WeightUnitCode::K;
        $st->L3[] = $l3;

        $this->assertEdi($this->loadFixture('204.edi'), $serialize->serialize($edi));
    }

    public function testSerialize997(): void
    {
        $dateTime = new \DateTimeImmutable('2024-01-31 11:00:00');
        $serialize = new X12Serializer('*', '~');

        $ak1 = new AK1Segment();
        $ak1->_01 = FunctionalIdentifierCode::SM;
        $ak1->_02 = 1;

        $ak9 = new AK9Segment();
        $ak9->_01 = FunctionalGroupAcknowledgeCode::A;
        $ak9->_02 = 1;
        $ak9->_03 = 1;
        $ak9->_04 = 1;

        $st = new TransactionSet997();
        $st->_01 = TransactionSetIdentifierCode::_997;
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
