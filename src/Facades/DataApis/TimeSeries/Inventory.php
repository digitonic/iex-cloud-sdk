<?php

namespace Digitonic\IexCloudSdk\Facades\DataApis\TimeSeries;

use Illuminate\Support\Facades\Facade;

class Inventory extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return \Digitonic\IexCloudSdk\DataApis\TimeSeries\Inventory::class;
    }
}
