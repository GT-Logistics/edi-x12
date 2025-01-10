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
use Gtlogistics\EdiX12\Qualifier\AcknowledgmentRequestedCode;
use Gtlogistics\EdiX12\Qualifier\AuthorizationInformationQualifier;
use Gtlogistics\EdiX12\Qualifier\InterchangeControlVersionNumberCode;
use Gtlogistics\EdiX12\Qualifier\InterchangeIDQualifier;
use Gtlogistics\EdiX12\Qualifier\InterchangeUsageIndicatorCode;
use Gtlogistics\EdiX12\Qualifier\SecurityInformationQualifier;

/**
 * @property string|AuthorizationInformationQualifier $authorizationInformationQualifier_01 **Authorization Information Qualifier:** Code identifying the type of information in the Authorization Information
 * @property string|AuthorizationInformationQualifier $_01 See $authorizationInformationQualifier_01
 * @property string $authorizationInformation_02 **Authorization Information:** Information used for additional identification or authorization of the interchange sender or the data in the interchange; the type of information is set by the Authorization Information Qualifier (I01)
 * @property string $_02 See $authorizationInformation_02
 * @property string|SecurityInformationQualifier $securityInformationQualifier_03 **Security Information Qualifier:** Code identifying the type of information in the Security Information
 * @property string|SecurityInformationQualifier $_03 See $securityInformationQualifier_03
 * @property string $securityInformation_04 **Security Information:** This is used for identifying the security information about the interchange sender or the data in the interchange; the type of information is set by the Security Information Qualifier (I03)
 * @property string $_04 See $securityInformation_04
 * @property string|InterchangeIDQualifier $interchangeReceiverIdQualifier_05 **Interchange ID Qualifier:** Code indicating the system/method of code structure used to designate the sender or receiver ID element being qualified
 * @property string|InterchangeIDQualifier $_05 See $interchangeReceiverIdQualifier_05
 * @property string $interchangeSenderId_06 **Interchange Sender ID:** Identification code published by the sender for other parties to use as the receiver ID to route data to them; the sender always codes this value in the sender ID element
 * @property string $_06 See $interchangeSenderId_06
 * @property string|InterchangeIDQualifier $interchangeSenderIdQualifier_07 **Interchange ID Qualifier:** Code indicating the system/method of code structure used to designate the sender or receiver ID element being qualified
 * @property string|InterchangeIDQualifier $_07 See $interchangeSenderIdQualifier_07
 * @property string $interchangeReceiverId_08 **Interchange Receiver ID:** Identification code published by the receiver of the data; When sending, it is used by the sender as their sending ID, thus other parties sending to them will use this as a receiving ID to route data to them
 * @property string $_08 See $interchangeReceiverId_08
 * @property \DateTimeInterface $interchangeDate_09 **Interchange Date:** Date of the interchange
 * @property \DateTimeInterface $_09 See $interchangeDate_09
 * @property \DateTimeInterface $interchangeTime_10 **Interchange Time:** Time of the interchange
 * @property \DateTimeInterface $_10 See $interchangeTime_10
 * @property string $repetitionSeparator_11 **Repetition Separator:** The repetition separator is a delimiter and not a data element; this field provides the delimiter used to separate repeated occurrences of a simple data element or a composite data structure; this value must be different than the data element separator, component element separator, and the segment terminator
 * @property string $_11 See $repetitionSeparator_11
 * @property string|InterchangeControlVersionNumberCode $interchangeControlVersionNumberCode_12 **Interchange Control Version Number Code:** Code indicating the system/method of code structure used to designate the sender or receiver ID element being qualified
 * @property string|InterchangeControlVersionNumberCode $_12 See $interchangeControlVersionNumberCode_12
 * @property int $interchangeControlNumber_13 @see $_13 **Interchange Control Number:** A control number assigned by the interchange sender
 * @property int $_13 See $interchangeControlNumber_13
 * @property string|AcknowledgmentRequestedCode $acknowledgementRequestedCode_14 **Acknowledgment Requested Code:** Code indicating sender's request for an interchange acknowledgment
 * @property string|AcknowledgmentRequestedCode $_14 See $acknowledgementRequestedCode_14
 * @property string|InterchangeUsageIndicatorCode $interchangeUsageIndicatorCode_15 **Interchange Usage Indicator Code:** Code indicating whether data enclosed by this interchange envelope is test, production or information
 * @property string|InterchangeUsageIndicatorCode $_15 See $interchangeUsageIndicatorCode_15
 * @property string $componentElementSeparator_16 **Component Element Separator:** The component element separator is a delimiter and not a data element; this field provides the delimiter used to separate component data elements within a composite data structure; this value must be different than the data element separator and the segment terminator
 * @property string $_16 See $componentElementSeparator_16
 */
final class IsaHeading extends AbstractSegment
{
    use EnumToStringTrait;

    /**
     * @var GsHeading[]
     */
    public array $GS = [];

    protected array $castings = [
        9 => 'date',
        10 => 'time',
        13 => 'int',
    ];

    protected array $lengths = [
        2 => [10, 10],
        4 => [10, 10],
        6 => [15, 15],
        8 => [15, 15],
        9 => [6, 6],
        10 => [4, 4],
        13 => [9, 9],
        16 => [1, 1],
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
        9 => true,
        10 => true,
        11 => true,
        12 => true,
        13 => true,
        14 => true,
        15 => true,
        16 => true,
    ];

    public function getId(): string
    {
        return 'ISA';
    }

    public function __serialize(): array
    {
        return [
            ...parent::__serialize(),
            'GS' => $this->GS,
        ];
    }
}
