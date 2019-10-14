<?php

namespace Digitonic\IexCloudSdk\Facades\Stocks;

use Illuminate\Support\Facades\Facade;

class Company extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return \Digitonic\IexCloudSdk\Stocks\Company::class;
    }
}
