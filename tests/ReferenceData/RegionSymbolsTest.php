<?php

namespace Digitonic\IexCloudSdk\Tests\ReferenceData;

use Digitonic\IexCloudSdk\Exceptions\WrongData;
use Digitonic\IexCloudSdk\Facades\ReferenceData\RegionSymbols;
use Digitonic\IexCloudSdk\Tests\BaseTestCase;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Collection;

class RegionSymbolsTest extends BaseTestCase
{
    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->response = new Response(200, [], '[{"symbol": "A-CV","exchange": "TSX","name": "lrosnAcmeMrI nri. a","date": "2019-10-04","type": "cs","iexId": "IEX_4656374258322D52","region": "CA","currency": "CAD","isEnabled": true},{"symbol": "AA-CV","exchange": "TSX","name": "lilraAd Lsanb .eMt","date": "2019-10-04","type": "cs","iexId": "IEX_4E44474238422D52","region": "CA","currency": "CAD","isEnabled": true},{"symbol": "AAAA-CV","exchange": "STX","name": "utl nIest. anvnrcsieeItmA","date": "2019-10-04","type": "cs","iexId": "IEX_465335594A332D52","region": "CA","currency": "CAD","isEnabled": true}]');

        $this->client = $this->setupMockedClient($this->response);
    }

    /** @test */
    public function it_should_fail_when_no_region_set()
    {
        $symbols = new \Digitonic\IexCloudSdk\ReferenceData\RegionSymbols($this->client);

        $this->expectException(WrongData::class);

        $symbols->get();
    }

    /** @test */
    public function it_can_query_the_region_symbols_endpoint()
    {
        $symbols = new \Digitonic\IexCloudSdk\ReferenceData\RegionSymbols($this->client);

        $response = $symbols->setRegion('ca')->get();

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
