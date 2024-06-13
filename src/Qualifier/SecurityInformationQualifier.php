<?php

namespace Gtlogistics\X12Parser\Qualifier;

enum SecurityInformationQualifier: string {
    case NO_SECURITY_INFORMATION_PRESENT_NO_MEANINGFUL_INFORMATION_IN_I04 = '00';
    case PASSWORD = '01';
}
