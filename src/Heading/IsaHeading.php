<?php

namespace Gtlogistics\X12Parser\Heading;


use Gtlogistics\X12Parser\Model\AbstractSegment;
use Gtlogistics\X12Parser\Qualifier\AcknowledgmentRequestedCode;
use Gtlogistics\X12Parser\Qualifier\AuthorizationInformationQualifier;
use Gtlogistics\X12Parser\Qualifier\InterchangeControlVersionNumberCode;
use Gtlogistics\X12Parser\Qualifier\InterchangeIDQualifier;
use Gtlogistics\X12Parser\Qualifier\InterchangeUsageIndicatorCode;
use Gtlogistics\X12Parser\Qualifier\SecurityInformationQualifier;

/**
 * @property AuthorizationInformationQualifier $ISA01 **Authorization Information Qualifier:** Code identifying the type of information in the Authorization Information
 * @property string $ISA02 **Authorization Information:** Information used for additional identification or authorization of the interchange sender or the data in the interchange; the type of information is set by the Authorization Information Qualifier (I01)
 * @property SecurityInformationQualifier $ISA03 **Security Information Qualifier:** Code identifying the type of information in the Security Information
 * @property string $ISA04 **Security Information:** This is used for identifying the security information about the interchange sender or the data in the interchange; the type of information is set by the Security Information Qualifier (I03)
 * @property InterchangeIDQualifier $ISA05 **Interchange ID Qualifier:** Code indicating the system/method of code structure used to designate the sender or receiver ID element being qualified
 * @property string $ISA06 **Interchange Sender ID:** Identification code published by the sender for other parties to use as the receiver ID to route data to them; the sender always codes this value in the sender ID element
 * @property InterchangeIDQualifier $ISA07 **Interchange ID Qualifier:** Code indicating the system/method of code structure used to designate the sender or receiver ID element being qualified
 * @property string $ISA08 **Interchange Receiver ID:** Identification code published by the receiver of the data; When sending, it is used by the sender as their sending ID, thus other parties sending to them will use this as a receiving ID to route data to them
 * @property \DateTimeInterface $ISA09 **Interchange Date:** Date of the interchange
 * @property \DateTimeInterface $ISA10 **Interchange Time:** Time of the interchange
 * @property string $ISA11 **Repetition Separator:** The repetition separator is a delimiter and not a data element; this field provides the delimiter used to separate repeated occurrences of a simple data element or a composite data structure; this value must be different than the data element separator, component element separator, and the segment terminator
 * @property InterchangeControlVersionNumberCode $ISA12 **Interchange Control Version Number Code:** Code indicating the system/method of code structure used to designate the sender or receiver ID element being qualified
 * @property int $ISA13 **Interchange Control Number:** A control number assigned by the interchange sender
 * @property AcknowledgmentRequestedCode $ISA14 **Acknowledgment Requested Code:** Code indicating sender's request for an interchange acknowledgment
 * @property InterchangeUsageIndicatorCode $ISA15 **Interchange Usage Indicator Code:** Code indicating whether data enclosed by this interchange envelope is test, production or information
 * @property string $ISA16 **Component Element Separator:** The component element separator is a delimiter and not a data element; this field provides the delimiter used to separate component data elements within a composite data structure; this value must be different than the data element separator and the segment terminator
 */
final class IsaHeading extends AbstractSegment
{
    protected array $castings = [
        'ISA01' => AuthorizationInformationQualifier::class,
        'ISA03' => SecurityInformationQualifier::class,
        'ISA05' => InterchangeIDQualifier::class,
        'ISA07' => InterchangeIDQualifier::class,
        'ISA09' => 'date',
        'ISA10' => 'time',
        'ISA12' => InterchangeControlVersionNumberCode::class,
        'ISA14' => AcknowledgmentRequestedCode::class,
        'ISA15' => InterchangeUsageIndicatorCode::class,
    ];

    /**
     * @var non-empty-list<GsHeading>
     */
    public array $GS = [];
}
