<?php

namespace Digitonic\IexCloudSdk\Tests\Stocks;

use Digitonic\IexCloudSdk\Exceptions\WrongData;
use Digitonic\IexCloudSdk\Facades\Stocks\KeyStats;
use Digitonic\IexCloudSdk\Tests\BaseTestCase;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Collection;

class KeyStatsTest extends BaseTestCase
{
    /**
     * @var \Digitonic\IexCloudSdk\Client
     */
    private $singleClient;

    /**
     * @var Response
     */
    private $singleResponse;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->response = new Response(200, [], '{
    "companyName": "Apple Inc.",
  "marketcap": 760334287200,
  "week52high": 156.65,
  "week52low": 93.63,
  "week52change": 58.801903,
  "sharesOutstanding": 5213840000,
  "float": 5203997571,
  "avg10Volume": 2774000,
  "avg30Volume": 12774000,
  "day200MovingAvg": 140.60541,
  "day50MovingAvg": 156.49678,
  "employees": 120000,
  "ttmEPS": 16.5,
  "ttmDividendRate": 2.25,
  "dividendYield": 0.021,
  "nextDividendDate": "2019-03-01",
  "exDividendDate": "2019-02-08",
  "nextEarningsDate": "2019-01-01",
  "peRatio": 14,
  "beta": 1.25,
  "maxChangePercent": 153.021,
  "year5ChangePercent": 0.5902546932200027,
  "year2ChangePercent": 0.3777449874142869,
  "year1ChangePercent": 0.39751716851558366,
  "ytdChangePercent": 0.36659492036160124,
  "month6ChangePercent": 0.12208398133748043,
  "month3ChangePercent": 0.08466584665846649,
  "month1ChangePercent": 0.009668596145283263,
  "day30ChangePercent": -0.002762605699968781,
  "day5ChangePercent": -0.005762605699968781
}');

        $this->singleResponse = new Response(200, [], '{
  "day50MovingAvg": 156.49678
}');

        $this->client = $this->setupMockedClient($this->response);
        $this->singleClient = $this->setupMockedClient($this->singleResponse);
    }

    /** @test */
    public function it_should_fail_without_a_symbol()
    {
        $stats = new \Digitonic\IexCloudSdk\Stocks\KeyStats($this->client);

        $this->expectException(WrongData::class);

        $stats->get();
    }

    /** @test */
    public function it_can_query_the_key_stats_endpoint()
    {
        $stats = new \Digitonic\IexCloudSdk\Stocks\KeyStats($this->client);

        $response = $stats->setSymbol('aapl')->get();

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(30, $response);
    }

    /** @test */
    public function it_can_query_a_specific_field_on_the_key_stats_endpoint()
    {
        $stats = new \Digitonic\IexCloudSdk\Stocks\KeyStats($this->singleClient);

        $response = $stats->setSymbol('aapl')->only('day50MovingAvg')->get();

        dd($response);

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(1, $response);
    }

    /** @test */
    public function it_can_call_the_facade()
    {
        $this->setConfig();

        KeyStats::shouldReceive('setSymbol')
            ->once()
            ->andReturnSelf();

        KeyStats::setSymbol('aapl');
    }
}
