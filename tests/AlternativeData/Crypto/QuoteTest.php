<?php

namespace Digitonic\IexCloudSdk\Tests\AlternativeData\Crypto;

use Digitonic\IexCloudSdk\Exceptions\WrongData;
use Digitonic\IexCloudSdk\Facades\AlternativeData\Crypto\Quote;
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

        $this->response = new Response(200, [], '{"symbol": "BTCUSDT","primaryExchange": "0","sector": "yyeoccnrrcpurt","calculationPrice": "realtime","latestPrice": "8369.7","latestSource": "Real time price","latestUpdate": 1614953755791,"latestVolume": null,"bidPrice": "8385.53","bidSize": "0.026913","askPrice": "8494.58","askSize": "0.027297","high": null,"low": null,"previousClose": null}');

        $this->client = $this->setupMockedClient($this->response);
    }

    /** @test */
    public function it_should_fail_without_a_symbol()
    {
        $crypto = new \Digitonic\IexCloudSdk\AlternativeData\Crypto\Quote($this->client);

        $this->expectException(WrongData::class);

        $crypto->get();
    }

    /** @test */
    public function it_can_query_the_crypto_endpoint()
    {
        $crypto = new \Digitonic\IexCloudSdk\AlternativeData\Crypto\Quote($this->client);

        $response = $crypto->setSymbol('aapl')->get();

        $this->assertInstanceOf(Collection::class, $response);

        $response = $response->toArray();
        $this->assertCount(15, $response);
        $this->assertEquals('yyeoccnrrcpurt', $response['sector']);
        $this->assertEquals('Real time price', $response['latestSource']);
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
