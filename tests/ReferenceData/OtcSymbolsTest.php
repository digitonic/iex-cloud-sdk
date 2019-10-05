<?php

namespace Digitonic\IexCloudSdk\Tests\ReferenceData;

use Digitonic\IexCloudSdk\Facades\ReferenceData\OtcSymbols;
use Digitonic\IexCloudSdk\Tests\BaseTestCase;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Collection;

class OtcSymbolsTest extends BaseTestCase
{
    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->response = new Response(200, [], '[{ "symbol": "AAAG", "exchange": "OTC", "name": "AC AroptI  yAr cunGuUe.nAS", "date": "2019-10-04", "type": "cs", "iexId": "IEX_4A534652444A2D52", "region": "US", "currency": "USD","isEnabled": true},{ "symbol": "AAAIF","exchange": "OTC", "name": "tTenmurevnrlviUt e Atsttnin asteIs","date": "2019-10-04","type": "cef", "iexId": "IEX_4B344E5839342D52","region": "US", "currency": "USD","isEnabled": true}]');

        $this->client = $this->setupMockedClient($this->response);
    }

    /** @test */
    public function it_can_query_the_symbols_endpoint()
    {
        $symbols = new \Digitonic\IexCloudSdk\ReferenceData\OtcSymbols($this->client);

        $response = $symbols->get();

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(2, $response);
        $this->assertEquals('AAAG', $response->first()->symbol);
        $this->assertEquals('OTC', $response->first()->exchange);
    }

    /** @test */
    public function it_can_call_the_facade()
    {
        $this->setConfig();

        OtcSymbols::shouldReceive('get')
            ->once()
            ->andReturn(collect(json_decode($this->response->getBody()->getContents())));

        $response = OtcSymbols::get();

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(2, $response);
        $this->assertEquals('AAAG', $response->first()->symbol);
        $this->assertEquals('OTC', $response->first()->exchange);
    }
}
