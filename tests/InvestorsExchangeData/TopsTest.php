<?php

namespace Digitonic\IexCloudSdk\Tests\InvestorsExchangeData;

use Digitonic\IexCloudSdk\Exceptions\WrongData;
use Digitonic\IexCloudSdk\Facades\InvestorsExchangeData\Tops;
use Digitonic\IexCloudSdk\Tests\BaseTestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Collection;

class TopsTest extends BaseTestCase
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

        $this->response = new Response(200, [], '[{"symbol": "AAPL","sector": "nicreetgtyclnolheooc","securityType": "sc","bidPrice": 0,"bidSize": 0,"askPrice": 0,"askSize": 0,"lastUpdated": 1640962930475,"lastSalePrice": 225.83,"lastSaleSize": 73,"lastSaleTime": 1641487716483,"volume": 298964},{"symbol": "MSFT","sector": "ehnorsegytocevlics","securityType": "sc","bidPrice": 0,"bidSize": 0,"askPrice": 0,"askSize": 0,"lastUpdated": 1571066822216,"lastSalePrice": 145.01,"lastSaleSize": 2,"lastSaleTime": 1571699873189,"volume": 468994}]');
    }

    /** @test */
    public function it_should_fail_without_a_symbol_or_symbols()
    {
        $mock = new MockHandler([$this->response]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $iexApi = new \Digitonic\IexCloudSdk\Client($client);

        $tops = new \Digitonic\IexCloudSdk\InvestorsExchangeData\Tops($iexApi);

        $this->expectException(WrongData::class);

        $tops->send();
    }

    /** @test */
    public function it_can_query_the_tops_endpoint()
    {
        $mock = new MockHandler([$this->response]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $iexApi = new \Digitonic\IexCloudSdk\Client($client);

        $tops = new \Digitonic\IexCloudSdk\InvestorsExchangeData\Tops($iexApi);

        $response = $tops->setSymbols('aapl')->send();

        $this->assertInstanceOf(Collection::class, $response);

        $response = $response->toArray();

        $this->assertCount(2, $response);
        $this->assertEquals('AAPL', $response[0]->symbol);
        $this->assertEquals('nicreetgtyclnolheooc', $response[0]->sector);
        $this->assertEquals(1641487716483, $response[0]->lastSaleTime);
    }

    /** @test */
    public function it_can_call_the_facade()
    {
        $this->app['config']->set('iex-cloud-sdk.base_url', 'https://cloud.iexapis.com/v1');
        $this->app['config']->set('iex-cloud-sdk.secret_key', 'KxDMt9GNVgu6fJUOG0UjH3d4kjZPTxFiXd5RnPhUD8Qz1Q2esNVIFfqmrqRD');
        $this->app['config']->set('iex-cloud-sdk.public_key', 'KxDMt9GNVgu6fJUOG0UjH3d4kjZPTxFiXd5RnPhUD8Qz1Q2esNVIFfqmrqRD');

        Tops::shouldReceive('setSymbols')
            ->once()
            ->andReturnSelf();

        Tops::setSymbols('aapl');
    }
}
