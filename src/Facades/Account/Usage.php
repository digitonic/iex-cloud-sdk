<?php

namespace Digitonic\IexCloudSdk\Facades\Account;

use Illuminate\Support\Facades\Facade;

class Usage extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return \Digitonic\IexCloudSdk\Account\Usage::class;
    }
}
