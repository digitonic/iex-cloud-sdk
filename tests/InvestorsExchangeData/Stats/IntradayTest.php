<?php

namespace Digitonic\IexCloudSdk\Tests\InvestorsExchangeData\Stats;

use Digitonic\IexCloudSdk\Facades\InvestorsExchangeData\Stats\Intraday;
use Digitonic\IexCloudSdk\Tests\BaseTestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Collection;

class IntradayTest extends BaseTestCase
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

        $this->response = new Response(200, [], '{"volume": {"value": 26908038,"lastUpdated": 1480433817323},"symbolsTraded": {"value": 4089,"lastUpdated": 1480433817323},"routedVolume": {"value": 10879651,"lastUpdated": 1480433816891},"notional": {"value": 1090683735,"lastUpdated": 1480433817323},"marketShare": {"value": 0.01691,"lastUpdated": 1480433817336}}');
    }

    /** @test */
    public function it_can_query_the_deep_trades_endpoint()
    {
        $mock = new MockHandler([$this->response]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $iexApi = new \Digitonic\IexCloudSdk\Client($client);

        $intraday = new \Digitonic\IexCloudSdk\InvestorsExchangeData\Stats\Intraday($iexApi);

        $response = $intraday->send();

        $this->assertInstanceOf(Collection::class, $response);

        $response = $response->toArray();
        $this->assertCount(5, $response);
    }

    /** @test */
    public function it_can_call_the_facade()
    {
        $this->app['config']->set('iex-cloud-sdk.base_url', 'https://cloud.iexapis.com/v1');
        $this->app['config']->set('iex-cloud-sdk.secret_key', 'KxDMt9GNVgu6fJUOG0UjH3d4kjZPTxFiXd5RnPhUD8Qz1Q2esNVIFfqmrqRD');
        $this->app['config']->set('iex-cloud-sdk.public_key', 'KxDMt9GNVgu6fJUOG0UjH3d4kjZPTxFiXd5RnPhUD8Qz1Q2esNVIFfqmrqRD');

        Intraday::shouldReceive('send')
            ->once()
            ->andReturn(collect(json_decode($this->response->getBody()->getContents())));

        Intraday::send();
    }
}
