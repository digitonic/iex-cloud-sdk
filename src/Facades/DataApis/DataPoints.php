<?php

namespace Digitonic\IexCloudSdk\Facades\DataApis;

use Illuminate\Support\Facades\Facade;

class DataPoints extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return \Digitonic\IexCloudSdk\DataApis\DataPoints::class;
    }
}
