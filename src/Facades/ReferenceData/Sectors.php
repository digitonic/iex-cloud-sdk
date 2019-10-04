<?php

namespace Digitonic\IexCloudSdk\Facades\ReferenceData;

use Illuminate\Support\Facades\Facade;

class Sectors extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return \Digitonic\IexCloudSdk\ReferenceData\Sectors::class;
    }
}
