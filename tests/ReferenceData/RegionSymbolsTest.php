<?php

namespace Digitonic\IexCloudSdk\Tests\ReferenceData;

use Digitonic\IexCloudSdk\Exceptions\WrongData;
use Digitonic\IexCloudSdk\Facades\ReferenceData\RegionSymbols;
use Digitonic\IexCloudSdk\Tests\BaseTestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Collection;

class RegionSymbolsTest extends BaseTestCase
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

        $this->response = new Response(200, [], '[{"symbol": "A-CV","exchange": "TSX","name": "lrosnAcmeMrI nri. a","date": "2019-10-04","type": "cs","iexId": "IEX_4656374258322D52","region": "CA","currency": "CAD","isEnabled": true},{"symbol": "AA-CV","exchange": "TSX","name": "lilraAd Lsanb .eMt","date": "2019-10-04","type": "cs","iexId": "IEX_4E44474238422D52","region": "CA","currency": "CAD","isEnabled": true},{"symbol": "AAAA-CV","exchange": "STX","name": "utl nIest. anvnrcsieeItmA","date": "2019-10-04","type": "cs","iexId": "IEX_465335594A332D52","region": "CA","currency": "CAD","isEnabled": true}]');
    }

    /** @test */
    public function it_should_fail_when_no_region_set()
    {
        $mock = new MockHandler([$this->response]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $iexApi = new \Digitonic\IexCloudSdk\Client($client);

        $symbols = new \Digitonic\IexCloudSdk\ReferenceData\RegionSymbols($iexApi);

        $this->expectException(WrongData::class);

        $symbols->send();
    }

    /** @test */
    public function it_can_query_the_region_symbols_endpoint()
    {
        $mock = new MockHandler([$this->response]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $iexApi = new \Digitonic\IexCloudSdk\Client($client);

        $symbols = new \Digitonic\IexCloudSdk\ReferenceData\RegionSymbols($iexApi);

        $response = $symbols->setRegion('ca')->send();

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(3, $response);
        $this->assertEquals('A-CV', $response->first()->symbol);
        $this->assertEquals('lrosnAcmeMrI nri. a', $response->first()->name);
    }

    /** @test */
    public function it_can_call_the_facade()
    {
        $this->setConfig();

        RegionSymbols::shouldReceive('setRegion')
            ->once()
            ->andReturnSelf();

        RegionSymbols::setRegion('ca');
    }
}
