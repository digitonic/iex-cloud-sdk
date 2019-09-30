<?php

namespace Digitonic\IexCloudSdk\Exceptions;

use Exception;

class WrongData extends Exception
{
    public static function invalidValuesProvided(string $message)
    {
        return new static($message);
    }
}
