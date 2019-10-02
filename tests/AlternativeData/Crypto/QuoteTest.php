<?php

namespace Digitonic\IexCloudSdk\Tests\AlternativeData\Crypto;

use Digitonic\IexCloudSdk\Exceptions\WrongData;
use Digitonic\IexCloudSdk\Facades\AlternativeData\Crypto\Quote;
use Digitonic\IexCloudSdk\Tests\BaseTestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Collection;

class QuoteTest extends BaseTestCase
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

        $this->response = new Response(200, [], '{"symbol": "BTCUSDT","primaryExchange": "0","sector": "yyeoccnrrcpurt","calculationPrice": "realtime","latestPrice": "8369.7","latestSource": "Real time price","latestUpdate": 1614953755791,"latestVolume": null,"bidPrice": "8385.53","bidSize": "0.026913","askPrice": "8494.58","askSize": "0.027297","high": null,"low": null,"previousClose": null}');
    }

    /** @test */
    public function it_should_fail_without_a_symbol()
    {
        $mock = new MockHandler([$this->response]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $iexApi = new \Digitonic\IexCloudSdk\Client($client);

        $crypto = new \Digitonic\IexCloudSdk\AlternativeData\Crypto\Quote($iexApi);

        $this->expectException(WrongData::class);

        $crypto->send();
    }

    /** @test */
    public function it_can_query_the_crypto_endpoint()
    {
        $mock = new MockHandler([$this->response]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $iexApi = new \Digitonic\IexCloudSdk\Client($client);

        $crypto = new \Digitonic\IexCloudSdk\AlternativeData\Crypto\Quote($iexApi);

        $response = $crypto->setSymbol('aapl')->send();

        $this->assertInstanceOf(Collection::class, $response);

        $response = $response->toArray();
        $this->assertCount(15, $response);
        $this->assertEquals('yyeoccnrrcpurt', $response['sector']);
        $this->assertEquals('Real time price', $response['latestSource']);
    }

    /** @test */
    public function it_can_call_the_facade()
    {
        $this->app['config']->set('iex-cloud-sdk.base_url', 'https://cloud.iexapis.com/v1');
        $this->app['config']->set('iex-cloud-sdk.secret_key', 'KxDMt9GNVgu6fJUOG0UjH3d4kjZPTxFiXd5RnPhUD8Qz1Q2esNVIFfqmrqRD');
        $this->app['config']->set('iex-cloud-sdk.public_key', 'KxDMt9GNVgu6fJUOG0UjH3d4kjZPTxFiXd5RnPhUD8Qz1Q2esNVIFfqmrqRD');

        Quote::shouldReceive('setSymbol')
            ->once()
            ->andReturnSelf();

        Quote::setSymbol('aapl');
    }
}
