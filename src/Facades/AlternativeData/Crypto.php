<?php

namespace Digitonic\IexCloudSdk\Facades\AlternativeData;

use Illuminate\Support\Facades\Facade;

class Crypto extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return \Digitonic\IexCloudSdk\AlternativeData\Crypto::class;
    }
}
