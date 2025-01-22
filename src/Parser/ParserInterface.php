<?php

namespace Gtlogistics\EdiX12\Parser;

use Gtlogistics\EdiX12\Edi;

interface ParserInterface
{
    public function parse(string $rawX12): Edi;
}
