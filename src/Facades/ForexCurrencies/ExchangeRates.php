<?php

namespace Digitonic\IexCloudSdk\Facades\ForexCurrencies;

use Illuminate\Support\Facades\Facade;

class ExchangeRates extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return \Digitonic\IexCloudSdk\ForexCurrencies\ExchangeRates::class;
    }
}
