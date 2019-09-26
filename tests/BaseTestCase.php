<?php

namespace Digitonic\IexCloudSdk\Tests;

use Digitonic\IexCloudSdk\Facades\Account\Metadata;
use Digitonic\IexCloudSdk\Facades\Account\Usage;
use Digitonic\IexCloudSdk\Facades\APISystemMetadata\Status;
use Digitonic\IexCloudSdk\Facades\ForexCurrencies\ExchangeRates;
use Digitonic\IexCloudSdk\Facades\ReferenceData\IEXSymbols;
use Digitonic\IexCloudSdk\Facades\ReferenceData\Symbols;
use Digitonic\IexCloudSdk\IexCloudSdkServiceProvider;
use Orchestra\Testbench\TestCase;

class BaseTestCase extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            IexCloudSdkServiceProvider::class
        ];
    }

    protected function getPackageAliases($app)
    {
        return [
            'Metadata' => Metadata::class,
            'Usage' => Usage::class,
            'Status' => Status::class,
            'ExchangeRates' => ExchangeRates::class,
            'IEXSymbols' => IEXSymbols::class,
            'Symbols' => Symbols::class,
        ];
    }
}
