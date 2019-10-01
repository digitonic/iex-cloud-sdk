<?php

namespace Digitonic\IexCloudSdk\Facades\InvestorsExchangeData;

use Illuminate\Support\Facades\Facade;

class Last extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return \Digitonic\IexCloudSdk\InvestorsExchangeData\Last::class;
    }
}
