<?php

namespace Digitonic\IexCloudSdk\Facades\InvestorsExchangeData;

use Illuminate\Support\Facades\Facade;

class Tops extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return \Digitonic\IexCloudSdk\InvestorsExchangeData\Tops::class;
    }
}
