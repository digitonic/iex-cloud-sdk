<?php

namespace Digitonic\IexCloudSdk\Tests\InvestorsExchangeData;

use Digitonic\IexCloudSdk\Exceptions\WrongData;
use Digitonic\IexCloudSdk\Facades\InvestorsExchangeData\Tops;
use Digitonic\IexCloudSdk\Tests\BaseTestCase;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Collection;

class TopsTest extends BaseTestCase
{
    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->response = new Response(200, [], '[{"symbol": "AAPL","sector": "nicreetgtyclnolheooc","securityType": "sc","bidPrice": 0,"bidSize": 0,"askPrice": 0,"askSize": 0,"lastUpdated": 1640962930475,"lastSalePrice": 225.83,"lastSaleSize": 73,"lastSaleTime": 1641487716483,"volume": 298964},{"symbol": "MSFT","sector": "ehnorsegytocevlics","securityType": "sc","bidPrice": 0,"bidSize": 0,"askPrice": 0,"askSize": 0,"lastUpdated": 1571066822216,"lastSalePrice": 145.01,"lastSaleSize": 2,"lastSaleTime": 1571699873189,"volume": 468994}]');

        $this->client = $this->setupMockedClient($this->response);
    }

    /** @test */
    public function it_should_fail_without_a_symbol_or_symbols()
    {
        $tops = new \Digitonic\IexCloudSdk\InvestorsExchangeData\Tops($this->client);

        $this->expectException(WrongData::class);

        $tops->get();
    }

    /** @test */
    public function it_can_query_the_tops_endpoint()
    {
        $tops = new \Digitonic\IexCloudSdk\InvestorsExchangeData\Tops($this->client);

        $response = $tops->setSymbols('aapl')->get();

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
        $this->setConfig();

        Tops::shouldReceive('setSymbols')
            ->once()
            ->andReturnSelf();

        Tops::setSymbols('aapl');
    }
}
