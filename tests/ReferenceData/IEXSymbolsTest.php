<?php

namespace Digitonic\IexCloudSdk\Tests\ReferenceData;

use Digitonic\IexCloudSdk\Facades\ReferenceData\IEXSymbols;
use Digitonic\IexCloudSdk\Tests\BaseTestCase;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Collection;

class IEXSymbolsTest extends BaseTestCase
{
    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->response = new Response(200, [], '[{"symbol": "A","date": "2017-04-19","isEnabled": true},{"symbol": "AA","date": "2017-04-19","isEnabled": true}]');

        $this->client = $this->setupMockedClient($this->response);
    }

    /** @test */
    public function it_can_query_the_iex_symbols_endpoint()
    {
        $symbols = new \Digitonic\IexCloudSdk\ReferenceData\IEXSymbols($this->client);

        $response = $symbols->get();

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(2, $response);
        $this->assertEquals('A', $response->first()->symbol);
        $this->assertEquals(true, $response->first()->isEnabled);
    }

    /** @test */
    public function it_can_call_the_facade()
    {
        $this->setConfig();

        IEXSymbols::shouldReceive('get')
            ->once()
            ->andReturn(collect(json_decode($this->response->getBody()->getContents())));

        $response = IEXSymbols::get();

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertEquals('AA', $response->all()[1]->symbol);
        $this->assertEquals('2017-04-19', $response->all()[1]->date);
    }
}
