<?php

namespace Digitonic\IexCloudSdk\Tests\Stocks;

use Digitonic\IexCloudSdk\Exceptions\WrongData;
use Digitonic\IexCloudSdk\Facades\Stocks\Price;
use Digitonic\IexCloudSdk\Facades\Stocks\PriceTarget;
use Digitonic\IexCloudSdk\Tests\BaseTestCase;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Collection;

class PriceTargetTest extends BaseTestCase
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
    "updatedDate": "2019-10-28",
    "priceTargetAverage": 229,
    "priceTargetHigh": 282,
    "priceTargetLow": 156,
    "numberOfAnalysts": 39
}');

        $this->client = $this->setupMockedClient($this->response);
    }

    /** @test */
    public function it_should_fail_without_a_symbol()
    {
        $priceTarget = new \Digitonic\IexCloudSdk\Stocks\PriceTarget($this->client);

        $this->expectException(WrongData::class);

        $priceTarget->get();
    }

    /** @test */
    public function it_can_query_the_price_target_endpoint()
    {
        $priceTarget = new \Digitonic\IexCloudSdk\Stocks\PriceTarget($this->client);

        $response = $priceTarget->setSymbol('aapl')->get();
        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(6, $response);
    }

    /** @test */
    public function it_can_call_the_facade()
    {
        $this->setConfig();

        PriceTarget::shouldReceive('setSymbol')
            ->once()
            ->andReturnSelf();

        PriceTarget::setSymbol('aapl');
    }
}
