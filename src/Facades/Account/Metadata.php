<?php

namespace Digitonic\IexCloudSdk\Facades\Account;

use Illuminate\Support\Facades\Facade;

class Metadata extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return \Digitonic\IexCloudSdk\Account\Metadata::class;
    }
}
