<?php

namespace Digitonic\IexCloudSdk\Tests\ForexCurrencies;

use Digitonic\IexCloudSdk\Facades\ForexCurrencies\ExchangeRates;
use Digitonic\IexCloudSdk\Tests\BaseTestCase;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Collection;

class ExchangeRatesTest extends BaseTestCase
{
    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->response = new Response(200, [], '{"fromCurrency": "GBP","toCurrency": "USD","rate": 0.9436089583568926,"date": "2019-09-24"}');

        $this->client = $this->setupMockedClient($this->response);
    }

    /** @test */
    public function it_can_query_the_forex_endpoint()
    {
        $forex = new \Digitonic\IexCloudSdk\ForexCurrencies\ExchangeRates($this->client);

        $response = $forex->setFrom('GBP')->setTo('USD')->get();

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(4, $response);
        $this->assertEquals('GBP', $response['fromCurrency']);
        $this->assertEquals('USD', $response['toCurrency']);
    }

    /** @test */
    public function it_can_call_the_facade()
    {
        $this->setConfig();

        ExchangeRates::shouldReceive('get')
            ->once()
            ->andReturn(collect(json_decode($this->response->getBody()->getContents())));

        $response = ExchangeRates::get();

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertEquals('GBP', $response['fromCurrency']);
        $this->assertEquals('USD', $response['toCurrency']);
    }
}
