<?php

namespace Gtlogistics\EdiX12\Serializer;

use Gtlogistics\EdiX12\Edi;

interface SerializerInterface
{
    public function serialize(Edi $edi): string;
}
