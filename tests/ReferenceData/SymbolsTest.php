<?php

namespace Digitonic\IexCloudSdk\Tests\ReferenceData;

use Digitonic\IexCloudSdk\Facades\ReferenceData\Symbols;
use Digitonic\IexCloudSdk\Tests\BaseTestCase;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Collection;

class SymbolsTest extends BaseTestCase
{
    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->response = new Response(200, [], '[{"symbol": "A","exchange": "YSN","name": "e TiinIghlsoecn l.Acneotg","date": "2019-09-25","type": "cs","iexId": "IEX_46574843354B2D52","region": "US","currency": "USD","isEnabled": true},{"symbol": "AA","exchange": "NSY","name": "Coo.lcApr a","date": "2019-09-25","type": "cs","iexId": "IEX_4238333734532D52","region": "US","currency": "USD","isEnabled": true},{"symbol": "AAAU","exchange": "ESP","name": "ry ttEhalGsn  oiTlMPdiecPF h","date": "2019-09-25","type": "et","iexId": "IEX_474B433136332D52","region": "US","currency": "USD","isEnabled": true}]');

        $this->client = $this->setupMockedClient($this->response);
    }

    /** @test */
    public function it_can_query_the_symbols_endpoint()
    {
        $symbols = new \Digitonic\IexCloudSdk\ReferenceData\Symbols($this->client);

        $response = $symbols->get();

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(3, $response);
        $this->assertEquals('A', $response->first()->symbol);
        $this->assertEquals('IEX_46574843354B2D52', $response->first()->iexId);
    }

    /** @test */
    public function it_can_call_the_facade()
    {
        $this->setConfig();

        Symbols::shouldReceive('get')
            ->once()
            ->andReturn(collect(json_decode($this->response->getBody()->getContents())));

        $response = Symbols::get();

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertEquals('AAAU', $response->all()[2]->symbol);
        $this->assertEquals('IEX_474B433136332D52', $response->all()[2]->iexId);

    }
}
