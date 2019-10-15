<?php

namespace Digitonic\IexCloudSdk\Facades\Stocks;

use Illuminate\Support\Facades\Facade;

class PriceTarget extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return \Digitonic\IexCloudSdk\Stocks\PriceTarget::class;
    }
}
