<?php

namespace Digitonic\IexCloudSdk\Tests\AlternativeData\Crypto;

use Digitonic\IexCloudSdk\Exceptions\WrongData;
use Digitonic\IexCloudSdk\Facades\AlternativeData\Crypto\Price;
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

        $this->response = new Response(200, [], '{"price": "8753.24","symbol": "BTCUSDT"}');

        $this->client = $this->setupMockedClient($this->response);
    }

    /** @test */
    public function it_should_fail_without_a_symbol()
    {
        $crypto = new \Digitonic\IexCloudSdk\AlternativeData\Crypto\Price($this->client);

        $this->expectException(WrongData::class);

        $crypto->get();
    }

    /** @test */
    public function it_can_query_the_crypto_endpoint()
    {
        $crypto = new \Digitonic\IexCloudSdk\AlternativeData\Crypto\Price($this->client);

        $response = $crypto->setSymbol('BTCUSDT')->get();

        $this->assertInstanceOf(Collection::class, $response);

        $response = $response->toArray();
        $this->assertCount(2, $response);
        $this->assertEquals('8753.24', $response['price']);
        $this->assertEquals('BTCUSDT', $response['symbol']);
    }

    /** @test */
    public function it_can_call_the_facade()
    {
        $this->setConfig();

        Price::shouldReceive('setSymbol')
            ->once()
            ->andReturnSelf();

        Price::setSymbol('BTCUSDT');
    }
}
