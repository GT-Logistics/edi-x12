<?php

namespace Gtlogistics\X12Parser\Heading;


use Gtlogistics\X12Parser\Model\AbstractSegment;
use Gtlogistics\X12Parser\Qualifier\FunctionalIdentifierCode;
use Gtlogistics\X12Parser\Qualifier\ResponsibleAgencyCode;
use Gtlogistics\X12Parser\Qualifier\VersionReleaseIndustryIdentifierCode;

/**
 * @property FunctionalIdentifierCode $GS01 **Functional Identifier Code:** Code identifying a group of application related transaction sets
 * @property string $GS02 **Application Sender's Code:** Code identifying party sending transmission; codes agreed to by trading partners
 * @property string $GS03 **Application Receiver's Code:** Code identifying party receiving transmission; codes agreed to by trading partners
 * @property \DateTimeInterface $GS04 **Date:** Date expressed as CCYYMMDD where CC represents the first two digits of the calendar year
 * @property \DateTimeInterface $GS05 **Time:** Time expressed in 24-hour clock time as follows: HHMM, or HHMMSS, or HHMMSSD, or HHMMSSDD, where H = hours (00-23), M = minutes (00-59), S = integer seconds (00-59) and DD = decimal seconds; decimal seconds are expressed as follows: D = tenths (0-9) and DD = hundredths (00-99)
 * @property string $GS06 **Group Control Number:** Assigned number originated and maintained by the sender
 * @property ResponsibleAgencyCode $GS07 **Responsible Agency Code:** Code identifying the issuer of the standard; this code is used in conjunction with Data Element 480
 * @property VersionReleaseIndustryIdentifierCode $GS08 **Version / Release / Industry Identifier Code:** Code indicating the version, release, and industry identifier of the EDI Standard being used, including the GS and GE segments; if the code in DE455 in the GS segment is X, then DE 480 positions 1-3 are the version number; positions 4-6 are the release level of the version; and positions 7-12 are the industry or trade association identifiers (optionally assigned by user); if the code in DE455 in the GS segment is T, other formats are allowed.
 */
final class GsHeading extends AbstractSegment
{
    protected array $castings = [
        'GS01' => FunctionalIdentifierCode::class,
        'GS04' => 'date',
        'GS05' => 'time',
        'GS07' => ResponsibleAgencyCode::class,
        'GS08' => VersionReleaseIndustryIdentifierCode::class,
    ];

    /**
     * @var non-empty-list<STSegment>
     */
    public array $ST = [];
}
