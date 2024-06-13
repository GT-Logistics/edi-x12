<?php

namespace Gtlogistics\X12Parser\Qualifier;

enum ResponsibleAgencyCode: string {
    case TRANSPORTATION_DATA_COORDINATING_COMMITTEE_TDCC = 'T';
    case ACCREDITED_STANDARDS_COMMITTEE_X12 = 'X';
}
