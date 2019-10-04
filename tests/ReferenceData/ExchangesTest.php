<?php

namespace Digitonic\IexCloudSdk\Tests\ReferenceData;

use Digitonic\IexCloudSdk\Facades\ReferenceData\Exchanges;
use Digitonic\IexCloudSdk\Tests\BaseTestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Collection;

class ExchangesTest extends BaseTestCase
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

        $this->response = new Response(200, [], '[{ "exchange": "DAS", "region": "AE", "description": "rgiDcuhachAiexbsti e naSbE eu", "mic": "DASX", "exchangeSuffix": "H-D"},{ "exchange": "AET", "region": "IL", "description": "cTtnEekiog  vchlevaA xS", "mic": "ETAX", "exchangeSuffix": "TI-"},{"exchange": "OBM","region": "IN","description": "dtB SEL.","mic": "OBMX","exchangeSuffix": "I-B"}]');
    }

    /** @test */
    public function it_can_query_the_region_symbols_endpoint()
    {
        $mock = new MockHandler([$this->response]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $iexApi = new \Digitonic\IexCloudSdk\Client($client);

        $exchanges = new \Digitonic\IexCloudSdk\ReferenceData\Exchanges($iexApi);

        $response = $exchanges->send();
        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(3, $response);
        $this->assertEquals('AE', $response->first()->region);
        $this->assertEquals('DAS', $response->first()->exchange);
        $this->assertEquals('rgiDcuhachAiexbsti e naSbE eu', $response->first()->description);
        $this->assertEquals('H-D', $response->first()->exchangeSuffix);
    }

    /** @test */
    public function it_can_call_the_facade()
    {
        $this->setConfig();

        Exchanges::shouldReceive('send')
            ->once()
            ->andReturn(collect(json_decode($this->response->getBody()->getContents())));

        Exchanges::send();
    }
}
