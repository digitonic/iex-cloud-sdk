<?php

namespace Digitonic\IexCloudSdk\Facades\InvestorsExchangeData\Stats;

use Illuminate\Support\Facades\Facade;

class Records extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return \Digitonic\IexCloudSdk\InvestorsExchangeData\Stats\Records::class;
    }
}
