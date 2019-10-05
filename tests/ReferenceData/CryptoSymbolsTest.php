<?php

namespace Digitonic\IexCloudSdk\Tests\ReferenceData;

use Digitonic\IexCloudSdk\Facades\ReferenceData\CryptoSymbols;
use Digitonic\IexCloudSdk\Tests\BaseTestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Collection;

class CryptoSymbolsTest extends BaseTestCase
{
    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->response = new Response(200, [], '[{"symbol": "BTCUSD","name": "otUcS iBo tinD","exchange": null,"date": "2019-10-01","type": "crypto","region": "US","currency": "USD","isEnabled": true},{"symbol": "ETHUSD","name": "trDtuShUeeo Em ","exchange": null,"date": "2019-10-01","type": "crypto","region": "US","currency": "USD","isEnabled": true}]');

        $this->client = $this->setupMockedClient($this->response);
    }

    /** @test */
    public function it_can_query_the_crypto_symbols_endpoint()
    {
        $symbols = new \Digitonic\IexCloudSdk\ReferenceData\CryptoSymbols($this->client);

        $response = $symbols->get();

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(2, $response);
        $this->assertEquals('BTCUSD', $response->first()->symbol);
        $this->assertEquals('otUcS iBo tinD', $response->first()->name);
    }

    /** @test */
    public function it_can_call_the_facade()
    {
        $this->setConfig();

        CryptoSymbols::shouldReceive('get')
            ->once()
            ->andReturn(collect(json_decode($this->response->getBody()->getContents())));

        $response = CryptoSymbols::get();

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertEquals('BTCUSD', $response->first()->symbol);
        $this->assertEquals('otUcS iBo tinD', $response->first()->name);
    }
}
