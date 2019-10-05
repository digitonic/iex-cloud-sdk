<?php

namespace Digitonic\IexCloudSdk\Tests\ReferenceData;

use Digitonic\IexCloudSdk\Exceptions\WrongData;
use Digitonic\IexCloudSdk\Facades\ReferenceData\ExchangeSymbols;
use Digitonic\IexCloudSdk\Tests\BaseTestCase;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Collection;

class ExchangeSymbolsTest extends BaseTestCase
{
    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->response = new Response(200, [], '[{"symbol": "AAB-CT","exchange": "ETS","name": "intarrlneAa n.nIdebte Incoe","date": "2019-10-04","type": "cs","iexId": "IEX_474334324A432D52","region": "CA","currency": "CAD","isEnabled": true},{"symbol": "AAV-CT","exchange": "ETS","name": "tl&.ndgaAiad GtL  v easO","date": "2019-10-04","type": "cs","iexId": "IEX_424B365943332D52","region": "CA","currency": "CAD","isEnabled": true},{"symbol": "ABT-CT","exchange": "ETS","name": "eotnuaSlbiorearotC sAtpo rfwo","date": "2019-10-04","type": "cs","iexId": "IEX_464757444A4E2D52","region": "CA","currency": "CAD","isEnabled": true}]');

        $this->client = $this->setupMockedClient($this->response);
    }

    /** @test */
    public function it_should_fail_when_no_region_set()
    {
        $symbols = new \Digitonic\IexCloudSdk\ReferenceData\ExchangeSymbols($this->client);

        $this->expectException(WrongData::class);

        $symbols->get();
    }

    /** @test */
    public function it_can_query_the_region_symbols_endpoint()
    {
        $symbols = new \Digitonic\IexCloudSdk\ReferenceData\ExchangeSymbols($this->client);

        $response = $symbols->setExchange('ETS')->get();

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(3, $response);
        $this->assertEquals('AAB-CT', $response->first()->symbol);
        $this->assertEquals('ETS', $response->first()->exchange);
        $this->assertEquals('intarrlneAa n.nIdebte Incoe', $response->first()->name);
    }

    /** @test */
    public function it_can_call_the_facade()
    {
        $this->setConfig();

        ExchangeSymbols::shouldReceive('setExchange')
            ->once()
            ->andReturnSelf();

        ExchangeSymbols::setExchange('ETS');
    }
}
