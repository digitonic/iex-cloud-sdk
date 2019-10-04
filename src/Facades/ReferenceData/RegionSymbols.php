<?php

namespace Digitonic\IexCloudSdk\Facades\ReferenceData;

use Illuminate\Support\Facades\Facade;

class RegionSymbols extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return \Digitonic\IexCloudSdk\ReferenceData\RegionSymbols::class;
    }
}
