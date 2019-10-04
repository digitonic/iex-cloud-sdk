<?php

namespace Digitonic\IexCloudSdk\Tests\InvestorsExchangeData\Deep;

use Digitonic\IexCloudSdk\Exceptions\WrongData;
use Digitonic\IexCloudSdk\Facades\InvestorsExchangeData\Deep\OfficialPrice;
use Digitonic\IexCloudSdk\Tests\BaseTestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Collection;

class OfficialPriceTest extends BaseTestCase
{
    /**
     * @var Response
     */
    private $response;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->response = new Response(200, [], '{"SNAP": {"priceType": "Open","price": 1.05,"timestamp": 1494595800005}}');
    }

    /** @test */
    public function it_should_fail_without_a_symbol()
    {
        $mock = new MockHandler([$this->response]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $iexApi = new \Digitonic\IexCloudSdk\Client($client);

        $price = new \Digitonic\IexCloudSdk\InvestorsExchangeData\Deep\OfficialPrice($iexApi);

        $this->expectException(WrongData::class);

        $price->send();
    }

    /** @test */
    public function it_can_query_the_official_price_endpoint()
    {
        $mock = new MockHandler([$this->response]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $iexApi = new \Digitonic\IexCloudSdk\Client($client);

        $price = new \Digitonic\IexCloudSdk\InvestorsExchangeData\Deep\OfficialPrice($iexApi);

        $response = $price->setSymbols('SNAP')->send();

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
