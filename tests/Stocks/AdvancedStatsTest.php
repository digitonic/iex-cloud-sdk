<?php

namespace Digitonic\IexCloudSdk\Tests\Stocks;

use Digitonic\IexCloudSdk\Exceptions\WrongData;
use Digitonic\IexCloudSdk\Facades\Stocks\AdvancedStats;
use Digitonic\IexCloudSdk\Tests\BaseTestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Collection;

class AdvancedStatsTest extends BaseTestCase
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
    "week52change": -0.032069,
    "week52high": 236.71,
    "week52low": 149,
    "marketcap": 1043546717496,
    "employees": 136720,
    "day200MovingAvg": 198.48,
    "day50MovingAvg": 214.86,
    "float": 4685714882.262021,
    "avg10Volume": 30694931.6,
    "avg30Volume": 28365346.97,
    "ttmEPS": 12.35,
    "ttmDividendRate": 2.96,
    "companyName": "Apple, Inc.",
    "sharesOutstanding": 4545416172,
    "maxChangePercent": 219.3671,
    "year5ChangePercent": 1.2561,
    "year2ChangePercent": 0.4423,
    "year1ChangePercent": -0.031606,
    "ytdChangePercent": 0.403195,
    "month6ChangePercent": 0.130824,
    "month3ChangePercent": 0.084027,
    "month1ChangePercent": 0.057907,
    "day30ChangePercent": 0.04115,
    "day5ChangePercent": 0.00916,
    "nextDividendDate": null,
    "dividendYield": 0.01393899881457589,
    "nextEarningsDate": "2019-11-06",
    "exDividendDate": "2019-08-19",
    "peRatio": 19.66,
    "beta": 1.5199640789251851,
    "totalCash": 68441480843,
    "currentDebt": 20929380342,
    "revenue": 266496254849,
    "grossProfit": 106490496342,
    "totalRevenue": 269728627821,
    "EBITDA": 83573214857,
    "revenuePerShare": 60.11,
    "revenuePerEmployee": 2090810.84,
    "debtToEquity": 1.08,
    "profitMargin": 0.2305084701699458,
    "enterpriseValue": 1053283033035,
    "enterpriseValueToRevenue": 4.05,
    "priceToSales": 3.8,
    "priceToBook": 9.559387728785357,
    "forwardPERatio": 19.81,
    "pegRatio": -2.8,
    "peHigh": 20.472408850103356,
    "peLow": 12.1758578473888}');

        $this->client = $this->setupMockedClient($this->response);
    }

    /** @test */
    public function it_should_fail_without_a_symbol()
    {
        $mock = new MockHandler([$this->response]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $iexApi = new \Digitonic\IexCloudSdk\Client($client);

        $advancedStats = new \Digitonic\IexCloudSdk\Stocks\AdvancedStats($iexApi);

        $this->expectException(WrongData::class);

        $advancedStats->get();
    }

    /** @test */
    public function it_can_query_the_advanced_stats_endpoint()
    {
        $mock = new MockHandler([$this->response]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $iexApi = new \Digitonic\IexCloudSdk\Client($client);

        $advancedStats = new \Digitonic\IexCloudSdk\Stocks\AdvancedStats($iexApi);

        $response = $advancedStats->setSymbol('aapl')->get();
        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(48, $response);

        $response = $response->toArray();
        $this->assertEquals(-0.032069, $response['week52change']);
        $this->assertEquals(236.71, $response['week52high']);
        $this->assertEquals(149, $response['week52low']);
    }

    /** @test */
    public function it_can_call_the_facade()
    {
        $this->setConfig();

        AdvancedStats::shouldReceive('setSymbol')
            ->once()
            ->andReturnSelf();

        AdvancedStats::setSymbol('aapl');
    }
}
