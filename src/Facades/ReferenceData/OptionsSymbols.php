<?php

namespace Digitonic\IexCloudSdk\Facades\ReferenceData;

use Illuminate\Support\Facades\Facade;

class OptionsSymbols extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return \Digitonic\IexCloudSdk\ReferenceData\OptionsSymbols::class;
    }
}
