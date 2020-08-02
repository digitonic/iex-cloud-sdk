<?php

namespace Digitonic\IexCloudSdk\Tests;

use Digitonic\IexCloudSdk\Facades\Account\Metadata;
use Digitonic\IexCloudSdk\Facades\Account\Usage;
use Digitonic\IexCloudSdk\Facades\APISystemMetadata\Status;
use Digitonic\IexCloudSdk\Facades\DataApis\DataPoints;
use Digitonic\IexCloudSdk\Facades\DataApis\TimeSeries\Inventory;
use Digitonic\IexCloudSdk\Facades\DataApis\TimeSeries\Query;
use Digitonic\IexCloudSdk\Facades\ForexCurrencies\ExchangeRates;
use Digitonic\IexCloudSdk\Facades\ReferenceData\IEXSymbols;
use Digitonic\IexCloudSdk\Facades\ReferenceData\Symbols;
use Digitonic\IexCloudSdk\Facades\Stocks\KeyStats;
use Digitonic\IexCloudSdk\IexCloudSdkServiceProvider;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Orchestra\Testbench\TestCase;

class BaseTestCase extends TestCase
{
    /**
     * @var \Digitonic\IexCloudSdk\Client
     */
    protected $client;

    /**
     * @var Response|null
     */
    protected $response = null;

    protected function setConfig(): void
    {
        $this->app['config']->set('iex-cloud-sdk.base_url', 'https://cloud.iexapis.com/v1');
        $this->app['config']->set('iex-cloud-sdk.secret_key', 'KxDMt9GNVgu6fJUOG0UjH3d4kjZPTxFiXd5RnPhUD8Qz1Q2esNVIFfqmrqRD');
        $this->app['config']->set('iex-cloud-sdk.public_key', 'KxDMt9GNVgu6fJUOG0UjH3d4kjZPTxFiXd5RnPhUD8Qz1Q2esNVIFfqmrqRD');
    }

    protected function setupMockedClient(Response $response)
    {
        $mock = new MockHandler([$response]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        return  new \Digitonic\IexCloudSdk\Client($client);
    }

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
            'DataPoints' => DataPoints::class,
            'Inventory' => Inventory::class,
            'Query' => Query::class,
            'KeyStats' => KeyStats::class,
        ];
    }
}
