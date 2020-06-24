<?php

namespace Digitonic\IexCloudSdk\Tests\Stocks;

use Digitonic\IexCloudSdk\Exceptions\WrongData;
use Digitonic\IexCloudSdk\Facades\Stocks\Quote;
use Digitonic\IexCloudSdk\Tests\BaseTestCase;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Collection;

class QuoteTest extends BaseTestCase
{
    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->response = new Response(200, [], '{
    "symbol": "AAPL",
    "companyName": "Apple Inc.",
    "calculationPrice": "tops",
    "open": 154,
    "openTime": 1506605400394,
    "close": 153.28,
    "closeTime": 1506605400394,
    "high": 154.80,
    "low": 153.25,
    "latestPrice": 158.73,
    "latestSource": "Previous close",
    "latestTime": "September 19, 2017",
    "latestUpdate": 1505779200000,
    "latestVolume": 20567140,
    "volume": 20567140,
    "iexRealtimePrice": 158.71,
    "iexRealtimeSize": 100,
    "iexLastUpdated": 1505851198059,
    "delayedPrice": 158.71,
    "delayedPriceTime": 1505854782437,
    "oddLotDelayedPrice": 158.70,
    "oddLotDelayedPriceTime": 1505854782436,
    "extendedPrice": 159.21,
    "extendedChange": -1.68,
    "extendedChangePercent": -0.0125,
    "extendedPriceTime": 1527082200361,
    "previousClose": 158.73,
    "previousVolume": 22268140,
    "change": -1.67,
    "changePercent": -0.01158,
    "iexMarketPercent": 0.00948,
    "iexVolume": 82451,
    "avgTotalVolume": 29623234,
    "iexBidPrice": 153.01,
    "iexBidSize": 100,
    "iexAskPrice": 158.66,
    "iexAskSize": 100,
    "marketCap": 751627174400,
    "week52High": 159.65,
    "week52Low": 93.63,
    "ytdChange": 0.3665,
    "peRatio": 17.18,
    "lastTradeTime": 1505779200000,
    "isUSMarketOpen": false}');

        $this->client = $this->setupMockedClient($this->response);
    }

    /** @test */
    public function it_should_fail_without_a_symbol()
    {
        $quote = new \Digitonic\IexCloudSdk\Stocks\Quote($this->client);

        $this->expectException(WrongData::class);

        $quote->get();
    }

    /** @test */
    public function it_can_query_the_quote_endpoint()
    {
        $quote = new \Digitonic\IexCloudSdk\Stocks\Quote($this->client);

        $response = $quote->setSymbol('aapl')->get();
        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(44, $response);
    }

    /** @test */
    public function it_can_call_the_facade()
    {
        $this->setConfig();

        Quote::shouldReceive('setSymbol')
            ->once()
            ->andReturnSelf();

        Quote::setSymbol('aapl');
    }
}
