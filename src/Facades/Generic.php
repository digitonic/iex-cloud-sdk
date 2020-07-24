<?php

namespace Digitonic\IexCloudSdk\Facades;

use Illuminate\Support\Facades\Facade;

class Generic extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return \Digitonic\IexCloudSdk\Requests\Generic::class;
    }
}
