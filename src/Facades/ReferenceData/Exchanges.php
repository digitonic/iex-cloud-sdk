<?php

namespace Digitonic\IexCloudSdk\Facades\ReferenceData;

use Illuminate\Support\Facades\Facade;

class Exchanges extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return \Digitonic\IexCloudSdk\ReferenceData\Exchanges::class;
    }
}
