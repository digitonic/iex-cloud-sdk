<?php

namespace Digitonic\IexCloudSdk\Tests\Stocks;

use Digitonic\IexCloudSdk\Exceptions\WrongData;
use Digitonic\IexCloudSdk\Facades\Stocks\Book;
use Digitonic\IexCloudSdk\Tests\BaseTestCase;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Collection;

class BookTest extends BaseTestCase
{
    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->response = new Response(200, [],'{
    "quote": {
        "symbol": "AAPL",
        "companyName": "Apple, Inc.",
        "primaryExchange": "DAANQS",
        "calculationPrice": "tops",
        "open": null,
        "openTime": null,
        "openSource": "ciaoflfi",
        "close": null,
        "closeTime": null,
        "closeSource": "iofalifc",
        "high": null,
        "highTime": 1591131872975,
        "highSource": " mery ei ecdp5tlunedia1",
        "low": null,
        "lowTime": 1632125986480,
        "lowSource": "1eluci eda e inypertd5m",
        "latestPrice": 259.82,
        "latestSource": "IEX price",
        "latestTime": "3:59:59 PM",
        "latestUpdate": 1612914311947,
        "latestVolume": null,
        "iexRealtimePrice": 262.9,
        "iexRealtimeSize": 105,
        "iexLastUpdated": 1657210098201,
        "delayedPrice": null,
        "delayedPriceTime": null,
        "oddLotDelayedPrice": null,
        "oddLotDelayedPriceTime": null,
        "extendedPrice": null,
        "extendedChange": null,
        "extendedChangePercent": null,
        "extendedPriceTime": null,
        "previousClose": 247.18,
        "previousVolume": 76321836,
        "change": 12.8,
        "changePercent": 0.0512,
        "volume": null,
        "iexMarketPercent": 0.011104466765221989,
        "iexVolume": 693346,
        "avgTotalVolume": 65685118,
        "iexBidPrice": 0,
        "iexBidSize": 0,
        "iexAskPrice": 0,
        "iexAskSize": 0,
        "iexOpen": null,
        "iexOpenTime": null,
        "iexClose": 40.419,
        "iexCloseTime": 1650135250872,
        "marketCap": 1169788407588,
        "peRatio": 21.02,
        "week52High": 328.65,
        "week52Low": 177.37,
        "ytdChange": -0.13586023719219945,
        "lastTradeTime": 1615790836322,
        "isUSMarketOpen": false
    },
    "bids": [],
    "asks": [],
    "trades": [],
    "systemEvent": {
        "systemEvent": "M",
        "timestamp": 1640427159794
    }
}');

        $this->client = $this->setupMockedClient($this->response);
    }

    /** @test */
    public function it_should_fail_without_a_symbol()
    {
        $price = new \Digitonic\IexCloudSdk\Stocks\Book($this->client);

        $this->expectException(WrongData::class);

        $price->get();
    }

    /** @test */
    public function it_can_query_the_book_endpoint()
    {
        $price = new \Digitonic\IexCloudSdk\Stocks\Book($this->client);

        $response = $price->setSymbol('aapl')->get();
        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(5, $response);
    }

    /** @test */
    public function it_can_call_the_facade()
    {
        $this->setConfig();

        Book::shouldReceive('setSymbol')
            ->once()
            ->andReturnSelf();

        Book::setSymbol('aapl');
    }
}
