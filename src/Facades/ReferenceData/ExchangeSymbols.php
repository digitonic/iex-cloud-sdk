<?php

namespace Digitonic\IexCloudSdk\Facades\ReferenceData;

use Illuminate\Support\Facades\Facade;

class ExchangeSymbols extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return \Digitonic\IexCloudSdk\ReferenceData\ExchangeSymbols::class;
    }
}
