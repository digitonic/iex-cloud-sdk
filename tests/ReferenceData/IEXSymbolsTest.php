<?php

namespace Digitonic\IexCloudSdk\Tests\ReferenceData;

use Digitonic\IexCloudSdk\Facades\ReferenceData\IEXSymbols;
use Digitonic\IexCloudSdk\Tests\BaseTestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Collection;

class IEXSymbolsTest extends BaseTestCase
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

        $this->response = new Response(200, [], '[{"symbol": "A","date": "2017-04-19","isEnabled": true},{"symbol": "AA","date": "2017-04-19","isEnabled": true}]');
    }

    /** @test */
    public function it_can_query_the_iex_symbols_endpoint()
    {
        $mock = new MockHandler([$this->response]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $iexApi = new \Digitonic\IexCloudSdk\Client($client);

        $symbols = new \Digitonic\IexCloudSdk\ReferenceData\IEXSymbols($iexApi);

        $response = $symbols->send();

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(2, $response);
        $this->assertEquals('A', $response->first()->symbol);
        $this->assertEquals(true, $response->first()->isEnabled);
    }

    /** @test */
    public function it_can_call_the_facade()
    {
        $this->app['config']->set('iex-cloud-sdk.base_url', 'https://cloud.iexapis.com/v1');
        $this->app['config']->set('iex-cloud-sdk.secret_key', 'KxDMt9GNVgu6fJUOG0UjH3d4kjZPTxFiXd5RnPhUD8Qz1Q2esNVIFfqmrqRD');
        $this->app['config']->set('iex-cloud-sdk.public_key', 'KxDMt9GNVgu6fJUOG0UjH3d4kjZPTxFiXd5RnPhUD8Qz1Q2esNVIFfqmrqRD');

        IEXSymbols::shouldReceive('send')
            ->once()
            ->andReturn(collect(json_decode($this->response->getBody()->getContents())));

        $response = IEXSymbols::send();

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertEquals('AA', $response->all()[1]->symbol);
        $this->assertEquals('2017-04-19', $response->all()[1]->date);
    }
}
