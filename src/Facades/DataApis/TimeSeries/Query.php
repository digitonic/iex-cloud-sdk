<?php

namespace Digitonic\IexCloudSdk\Facades\DataApis\TimeSeries;

use Illuminate\Support\Facades\Facade;

class Query extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return \Digitonic\IexCloudSdk\DataApis\TimeSeries\Query::class;
    }
}
