<?php

namespace Digitonic\IexCloudSdk\Tests\ReferenceData;

use Digitonic\IexCloudSdk\Facades\ReferenceData\MutualFundSymbols;
use Digitonic\IexCloudSdk\Tests\BaseTestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Collection;

class MutualFundSymbolsTest extends BaseTestCase
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

        $this->response = new Response(200, [], '[{"symbol": "1SSEMYM1-MM","exchange": "XME","name": "nn l oSio iCtna Me r ee B dedrfo eofGedA3 Sv1orleieVaiitnsrPo","date": "2019-10-04","type": "oef","iexId": "IEX_485A304E42592D52","region": "MX","currency": "MXN","isEnabled": true},{"symbol": "1SSEMYMA2-MM","exchange": "MXE","name": "roAedeff B3stlt v PiGe noe iinVCrAeo-noe2 e ed Sdal-o ioairr SnM","date": "2019-10-04","type": "oef","iexId": "IEX_4A4B355446472D52","region": "MX","currency": "MXN","isEnabled": true}]');
    }

    /** @test */
    public function it_can_query_the_symbols_endpoint()
    {
        $mock = new MockHandler([$this->response]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $iexApi = new \Digitonic\IexCloudSdk\Client($client);

        $mutualFundSymbols = new \Digitonic\IexCloudSdk\ReferenceData\MutualFundSymbols($iexApi);

        $response = $mutualFundSymbols->send();

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(2, $response);
        $this->assertEquals('1SSEMYM1-MM', $response->first()->symbol);
        $this->assertEquals('XME', $response->first()->exchange);
        $this->assertEquals('2019-10-04', $response->first()->date);
        $this->assertEquals('IEX_485A304E42592D52', $response->first()->iexId);
    }

    /** @test */
    public function it_can_call_the_facade()
    {
        $this->setConfig();

        MutualFundSymbols::shouldReceive('send')
            ->once()
            ->andReturn(collect(json_decode($this->response->getBody()->getContents())));

        $response = MutualFundSymbols::send();

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(2, $response);
        $this->assertEquals('1SSEMYM1-MM', $response->first()->symbol);
        $this->assertEquals('XME', $response->first()->exchange);
        $this->assertEquals('2019-10-04', $response->first()->date);
        $this->assertEquals('IEX_485A304E42592D52', $response->first()->iexId);
    }
}
