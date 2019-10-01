<?php

namespace Digitonic\IexCloudSdk\Facades\InvestorsExchangeData;

use Illuminate\Support\Facades\Facade;

class Deep extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return \Digitonic\IexCloudSdk\InvestorsExchangeData\Deep::class;
    }
}
