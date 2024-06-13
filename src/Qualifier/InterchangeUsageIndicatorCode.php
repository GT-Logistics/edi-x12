<?php

namespace Gtlogistics\X12Parser\Qualifier;

enum InterchangeUsageIndicatorCode: string {
    case INFORMATION = 'I';
    case PRODUCTION_DATA = 'P';
    case TEST_DATA = 'T';
}
