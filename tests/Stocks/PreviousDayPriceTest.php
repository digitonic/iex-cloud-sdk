<?php

namespace Digitonic\IexCloudSdk\Tests\Stocks;

use Digitonic\IexCloudSdk\Client;
use Digitonic\IexCloudSdk\Exceptions\WrongData;
use Digitonic\IexCloudSdk\Facades\Stocks\PreviousDayPrice;
use Digitonic\IexCloudSdk\Facades\Stocks\Price;
use Digitonic\IexCloudSdk\Tests\BaseTestCase;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Collection;

class PreviousDayPriceTest extends BaseTestCase
{
    /**
     * @var Response
     */
    private $marketResponse;

    /**
     * @var Response
     */
    private $symbolResponse;

    /**
     * @var Client
     */
    private $clientMarket;

    /**
     * @var Client
     */
    private $clientSymbol;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->symbolResponse = new Response(200, [], '{
    "date": "2019-10-14",
    "open": 236.3,
    "close": 242.59,
    "high": 242.24,
    "low": 242.32,
    "volume": 25487438,
    "uOpen": 240.9,
    "uClose": 241.54,
    "uHigh": 245.22,
    "uLow": 246.02,
    "uVolume": 25325948,
    "change": 0,
    "changePercent": 0,
    "changeOverTime": 0,
    "symbol": "AAPL"
}');
        $this->marketResponse = new Response(200, [], '[
    {
        "date": "2019-06-19",
        "open": 0,
        "close": 15.06,
        "high": 0,
        "low": 0,
        "volume": 0,
        "uOpen": 0,
        "uClose": 15.17,
        "uHigh": 0,
        "uLow": 0,
        "uVolume": 0,
        "change": 0,
        "changePercent": 0,
        "changeOverTime": 0,
        "symbol": "OIPIX"
    },
    {
        "date": "2019-10-14",
        "open": null,
        "close": 22.28,
        "high": null,
        "low": null,
        "volume": 117,
        "uOpen": null,
        "uClose": 21.87,
        "uHigh": null,
        "uLow": null,
        "uVolume": 118,
        "change": 0,
        "changePercent": 0,
        "changeOverTime": 0,
        "symbol": "LNGR"
    },
    {
        "date": "2019-06-19",
        "open": 0,
        "close": 9.85,
        "high": 0,
        "low": 0,
        "volume": 0,
        "uOpen": 0,
        "uClose": 9.99,
        "uHigh": 0,
        "uLow": 0,
        "uVolume": 0,
        "change": 0,
        "changePercent": 0,
        "changeOverTime": 0,
        "symbol": "RBDRX"
    }]');

        $this->clientMarket = $this->setupMockedClient($this->marketResponse);
        $this->clientSymbol = $this->setupMockedClient($this->symbolResponse);
    }

    /** @test */
    public function it_should_fail_without_a_symbol()
    {
        $price = new \Digitonic\IexCloudSdk\Stocks\PreviousDayPrice($this->clientSymbol);

        $this->expectException(WrongData::class);

        $price->get();
    }

    /** @test */
    public function it_can_query_the_previous_day_price_endpoint_for_symbol()
    {
        $price = new \Digitonic\IexCloudSdk\Stocks\PreviousDayPrice($this->clientSymbol);

        $response = $price->setSymbol('aapl')->get();
        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(15, $response);
    }

    /** @test */
    public function it_can_query_the_previous_day_price_endpoint_for_market()
    {
        $price = new \Digitonic\IexCloudSdk\Stocks\PreviousDayPrice($this->clientMarket);

        $response = $price->setSymbol('market')->get();
        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(3, $response);
    }

    /** @test */
    public function it_can_call_the_facade()
    {
        $this->setConfig();

        PreviousDayPrice::shouldReceive('setSymbol')
            ->once()
            ->andReturnSelf();

        PreviousDayPrice::setSymbol('aapl');
    }
}
