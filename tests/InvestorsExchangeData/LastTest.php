<?php

namespace Digitonic\IexCloudSdk\Tests\InvestorsExchangeData;

use Digitonic\IexCloudSdk\Exceptions\WrongData;
use Digitonic\IexCloudSdk\Facades\InvestorsExchangeData\Last;
use Digitonic\IexCloudSdk\Facades\InvestorsExchangeData\Tops;
use Digitonic\IexCloudSdk\Tests\BaseTestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Collection;

class LastTest extends BaseTestCase
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

        $this->response = new Response(200, [], '[{"symbol": "AAPL","price": 224.31,"size": 72,"time": 1637402059397},{"symbol": "MSFT","price": 145.79,"size": 2,"time": 1590899367463}]');
    }

    /** @test */
    public function it_should_fail_without_a_symbol_or_symbols()
    {
        $mock = new MockHandler([$this->response]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $iexApi = new \Digitonic\IexCloudSdk\Client($client);

        $last = new \Digitonic\IexCloudSdk\InvestorsExchangeData\Last($iexApi);

        $this->expectException(WrongData::class);

        $last->send();
    }

    /** @test */
    public function it_can_query_the_tops_endpoint()
    {
        $mock = new MockHandler([$this->response]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $iexApi = new \Digitonic\IexCloudSdk\Client($client);

        $last = new \Digitonic\IexCloudSdk\InvestorsExchangeData\Last($iexApi);

        $response = $last->setSymbols('aapl')->send();

        $this->assertInstanceOf(Collection::class, $response);

        $response = $response->toArray();

        $this->assertCount(2, $response);
        $this->assertEquals('AAPL', $response[0]->symbol);
        $this->assertEquals(224.31, $response[0]->price);
        $this->assertEquals(1637402059397, $response[0]->time);
    }

    /** @test */
    public function it_can_call_the_facade()
    {
        $this->setConfig();

        Last::shouldReceive('setSymbols')
            ->once()
            ->andReturnSelf();

        Last::setSymbols('aapl');
    }
}
