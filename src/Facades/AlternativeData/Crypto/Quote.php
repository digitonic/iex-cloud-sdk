<?php

namespace Digitonic\IexCloudSdk\Facades\AlternativeData\Crypto;

use Illuminate\Support\Facades\Facade;

class Quote extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return \Digitonic\IexCloudSdk\AlternativeData\Crypto\Quote::class;
    }
}
