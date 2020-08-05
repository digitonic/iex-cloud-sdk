<?php

namespace Digitonic\IexCloudSdk\Tests\Stocks;

use Digitonic\IexCloudSdk\Exceptions\WrongData;
use Digitonic\IexCloudSdk\Facades\Stocks\IntradayPrices;
use Digitonic\IexCloudSdk\Facades\Stocks\Price;
use Digitonic\IexCloudSdk\Facades\Stocks\PriceTarget;
use Digitonic\IexCloudSdk\Tests\BaseTestCase;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Collection;

class IntradayPricesTest extends BaseTestCase
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
        "date": "2017-12-15",
        "minute": "09:30",
        "label": "09:30 AM",
        "marketOpen": 143.98,
        "marketClose": 143.775,
        "marketHigh": 143.98,
        "marketLow": 143.775,
        "marketAverage": 143.889,
        "marketVolume": 3070,
        "marketNotional": 441740.275,
        "marketNumberOfTrades": 20,
        "marketChangeOverTime": -0.004,
        "high": 143.98,
        "low": 143.775,
        "open": 143.98,
        "close": 143.775,
        "average": 143.889,
        "volume": 3070,
        "notional": 441740.275,
        "numberOfTrades": 20,
        "changeOverTime": -0.0039
    }');

        $this->client = $this->setupMockedClient($this->response);
    }

    /** @test */
    public function it_should_fail_without_a_symbol()
    {
        $prices = new \Digitonic\IexCloudSdk\Stocks\IntradayPrices($this->client);

        $this->expectException(WrongData::class);

        $prices->get();
    }

    /** @test */
    public function it_can_query_the_intraday_prices_endpoint()
    {
        $prices = new \Digitonic\IexCloudSdk\Stocks\IntradayPrices($this->client);

        $response = $prices->setSymbol('aapl')->get();
        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(21, $response);
    }

    /** @test */
    public function it_can_call_the_facade()
    {
        $this->setConfig();

        IntradayPrices::shouldReceive('setSymbol')
            ->once()
            ->andReturnSelf();

        IntradayPrices::setSymbol('aapl');
    }
}
