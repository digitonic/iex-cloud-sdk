<?php

namespace Digitonic\IexCloudSdk\Tests\InvestorsExchangeData\Deep;

use Digitonic\IexCloudSdk\Exceptions\WrongData;
use Digitonic\IexCloudSdk\Facades\InvestorsExchangeData\Deep\OfficialPrice;
use Digitonic\IexCloudSdk\Tests\BaseTestCase;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Collection;

class OfficialPriceTest extends BaseTestCase
{
    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->response = new Response(200, [], '{"SNAP": {"priceType": "Open","price": 1.05,"timestamp": 1494595800005}}');

        $this->client = $this->setupMockedClient($this->response);
    }

    /** @test */
    public function it_should_fail_without_a_symbol()
    {
        $price = new \Digitonic\IexCloudSdk\InvestorsExchangeData\Deep\OfficialPrice($this->client);

        $this->expectException(WrongData::class);

        $price->get();
    }

    /** @test */
    public function it_can_query_the_official_price_endpoint()
    {
        $price = new \Digitonic\IexCloudSdk\InvestorsExchangeData\Deep\OfficialPrice($this->client);

        $response = $price->setSymbols('SNAP')->get();

        $this->assertInstanceOf(Collection::class, $response);

        $response = $response->toArray();
        $this->assertCount(1, $response);
        $this->assertCount(3, (array) $response['SNAP']);
        $this->assertEquals(1.05, $response['SNAP']->price);
        $this->assertEquals("Open", $response['SNAP']->priceType);
        $this->assertEquals(1494595800005, $response['SNAP']->timestamp);
    }

    /** @test */
    public function it_can_call_the_facade()
    {
        $this->setConfig();

        OfficialPrice::shouldReceive('setSymbols')
            ->once()
            ->andReturnSelf();

        OfficialPrice::setSymbols('SNAP');
    }
}
