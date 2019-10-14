<?php

namespace Digitonic\IexCloudSdk\Tests\Stocks;

use Digitonic\IexCloudSdk\Exceptions\WrongData;
use Digitonic\IexCloudSdk\Facades\Stocks\Price;
use Digitonic\IexCloudSdk\Tests\BaseTestCase;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Collection;

class PriceTest extends BaseTestCase
{
    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->response = new Response(200, [], '237.65');

        $this->client = $this->setupMockedClient($this->response);
    }

    /** @test */
    public function it_should_fail_without_a_symbol()
    {
        $logo = new \Digitonic\IexCloudSdk\Stocks\Price($this->client);

        $this->expectException(WrongData::class);

        $logo->get();
    }

    /** @test */
    public function it_can_query_the_news_endpoint()
    {
        $logo = new \Digitonic\IexCloudSdk\Stocks\Price($this->client);

        $response = $logo->setSymbol('aapl')->get();
        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(1, $response);
    }

    /** @test */
    public function it_can_call_the_facade()
    {
        $this->setConfig();

        Price::shouldReceive('setSymbol')
            ->once()
            ->andReturnSelf();

        Price::setSymbol('aapl');
    }
}
