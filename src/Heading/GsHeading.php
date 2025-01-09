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

namespace Gtlogistics\EdiX12\Heading;

use Gtlogistics\EdiX12\Model\AbstractSegment;
use Gtlogistics\EdiX12\Model\TransactionSetInterface;
use Gtlogistics\EdiX12\Qualifier\FunctionalIdentifierCode;
use Gtlogistics\EdiX12\Qualifier\ResponsibleAgencyCode;
use Gtlogistics\EdiX12\Qualifier\VersionReleaseIndustryIdentifierCode;

/**
 * @property string|FunctionalIdentifierCode $functionalIdentifierCode_01 **Functional Identifier Code:** Code identifying a group of application related transaction sets
 * @property string|FunctionalIdentifierCode $_01 See $functionalIdentifierCode_01
 * @property string $applicationSendersCode_02 **Application Sender's Code:** Code identifying party sending transmission; codes agreed to by trading partners
 * @property string $_02 See $applicationSendersCode_02
 * @property string $applicationReceiversCode_03 **Application Receiver's Code:** Code identifying party receiving transmission; codes agreed to by trading partners
 * @property string $_03 See $applicationReceiversCode_03
 * @property \DateTimeImmutable $date_04 **Date:** Date expressed as CCYYMMDD where CC represents the first two digits of the calendar year
 * @property \DateTimeInterface $_04 See $date_04
 * @property \DateTimeInterface $time_05 **Time:** Time expressed in 24-hour clock time as follows: HHMM, or HHMMSS, or HHMMSSD, or HHMMSSDD, where H = hours (00-23), M = minutes (00-59), S = integer seconds (00-59) and DD = decimal seconds; decimal seconds are expressed as follows: D = tenths (0-9) and DD = hundredths (00-99)
 * @property \DateTimeInterface $_05 See $time_05
 * @property int $groupControlNumber_06 **Group Control Number:** Assigned number originated and maintained by the sender
 * @property int $_06 See $groupControlNumber_06
 * @property string|ResponsibleAgencyCode $responsibleAgencyCode_07 **Responsible Agency Code:** Code identifying the issuer of the standard; this code is used in conjunction with Data Element 480
 * @property string|ResponsibleAgencyCode $_07 See $responsibleAgencyCode_07
 * @property string|VersionReleaseIndustryIdentifierCode $versionReleaseIndustryIdentifierCode_08 **Version / Release / Industry Identifier Code:** Code indicating the version, release, and industry identifier of the EDI Standard being used, including the GS and GE segments; if the code in DE455 in the GS segment is X, then DE 480 positions 1-3 are the version number; positions 4-6 are the release level of the version; and positions 7-12 are the industry or trade association identifiers (optionally assigned by user); if the code in DE455 in the GS segment is T, other formats are allowed.
 * @property string|VersionReleaseIndustryIdentifierCode $_08 See $versionReleaseIndustryIdentifierCode_08
 */
final class GsHeading extends AbstractSegment
{
    use EnumToStringTrait;

    protected array $castings = [
        4 => 'date',
        5 => 'time',
        6 => 'int',
    ];

    protected array $lengths = [
        2 => [2, 15],
        3 => [2, 15],
        4 => [8, 8],
        5 => [4, 8],
        6 => [1, 9],
    ];

    protected array $required = [
        1 => true,
        2 => true,
        3 => true,
        4 => true,
        5 => true,
        6 => true,
        7 => true,
        8 => true,
    ];

    /**
     * @var TransactionSetInterface[]
     */
    public array $ST = [];

    public function getId(): string
    {
        return 'GS';
    }
}
