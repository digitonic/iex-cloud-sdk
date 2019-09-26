<?php

namespace Digitonic\IexCloudSdk\Facades\APISystemMetadata;

use Illuminate\Support\Facades\Facade;

class Status extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return \Digitonic\IexCloudSdk\APISystemMetadata\Status::class;
    }
}
