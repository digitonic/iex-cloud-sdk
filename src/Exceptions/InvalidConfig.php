<?php

namespace Digitonic\IexCloudSdk\Exceptions;

use Exception;

class InvalidConfig extends Exception
{
    public static function apiKeyNotSpecified()
    {
        return new static('An API key is required to access this data and no key was provided');
    }

    public static function baseUrlNotSpecified()
    {
        return new static('You must provide a valid Base URL to query the IEX Cloud API');
    }
}
