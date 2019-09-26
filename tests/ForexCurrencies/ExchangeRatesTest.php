<?php

namespace Digitonic\IexCloudSdk\Tests\ForexCurrencies;

use Digitonic\IexCloudSdk\Facades\ForexCurrencies\ExchangeRates;
use Digitonic\IexCloudSdk\Tests\BaseTestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Collection;

class ExchangeRatesTest extends BaseTestCase
{
    /** @test */
    public function it_can_query_the_forex_endpoint()
    {
        $mock = new MockHandler([
            new Response(200, [], '{"fromCurrency": "GBP","toCurrency": "USD","rate": 0.9436089583568926,"date": "2019-09-24"}')
        ]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $iexApi = new \Digitonic\IexCloudSdk\Client($client);

        $forex = new \Digitonic\IexCloudSdk\ForexCurrencies\ExchangeRates($iexApi);

        $response = $forex->setFrom('GBP')->setTo('USD')->send();

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(4, $response);
        $this->assertEquals('GBP', $response['fromCurrency']);
        $this->assertEquals('USD', $response['toCurrency']);
    }

    /** @test */
    public function it_can_call_the_facade()
    {
        $this->app['config']->set('iex-cloud-sdk.base_url', 'https://cloud.iexapis.com/v1');
        $this->app['config']->set('iex-cloud-sdk.secret_key', 'KxDMt9GNVgu6fJUOG0UjH3d4kjZPTxFiXd5RnPhUD8Qz1Q2esNVIFfqmrqRD');
        $this->app['config']->set('iex-cloud-sdk.public_key', 'KxDMt9GNVgu6fJUOG0UjH3d4kjZPTxFiXd5RnPhUD8Qz1Q2esNVIFfqmrqRD');

        $response = new Response(200, [], '{"fromCurrency": "GBP","toCurrency": "EUR","rate": 0.9436089583568926,"date": "2019-09-24"}');

        ExchangeRates::shouldReceive('send')
            ->once()
            ->andReturn(collect(json_decode($response->getBody()->getContents())));

        $response = ExchangeRates::send();

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertEquals('GBP', $response['fromCurrency']);
        $this->assertEquals('EUR', $response['toCurrency']);

    }
}
