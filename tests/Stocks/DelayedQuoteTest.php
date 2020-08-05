<?php

namespace Digitonic\IexCloudSdk\Tests\Stocks;

use Digitonic\IexCloudSdk\Exceptions\WrongData;
use Digitonic\IexCloudSdk\Facades\Stocks\DelayedQuote;
use Digitonic\IexCloudSdk\Tests\BaseTestCase;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Collection;

class DelayedQuoteTest extends BaseTestCase
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
  "delayedPrice": 143.08,
  "delayedSize": 200,
  "delayedPriceTime": 1498762739791,
  "high": 143.90,
  "low": 142.26,
  "totalVolume": 33547893,
  "processedTime": 1498763640156
}');

        $this->client = $this->setupMockedClient($this->response);
    }

    /** @test */
    public function it_should_fail_without_a_symbol()
    {
        $quote = new \Digitonic\IexCloudSdk\Stocks\DelayedQuote($this->client);

        $this->expectException(WrongData::class);

        $quote->get();
    }

    /** @test */
    public function it_can_query_the_delayed_quote_endpoint()
    {
        $quote = new \Digitonic\IexCloudSdk\Stocks\DelayedQuote($this->client);

        $response = $quote->setSymbol('aapl')->get();
        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(8, $response);
    }

    /** @test */
    public function it_can_call_the_facade()
    {
        $this->setConfig();

        DelayedQuote::shouldReceive('setSymbol')
            ->once()
            ->andReturnSelf();

        DelayedQuote::setSymbol('aapl');
    }
}
