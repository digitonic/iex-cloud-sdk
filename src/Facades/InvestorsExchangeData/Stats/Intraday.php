<?php

namespace Digitonic\IexCloudSdk\Facades\InvestorsExchangeData\Stats;

use Illuminate\Support\Facades\Facade;

class Intraday extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return \Digitonic\IexCloudSdk\InvestorsExchangeData\Stats\Intraday::class;
    }
}
