<?php

namespace Digitonic\IexCloudSdk\Tests\ReferenceData;

use Digitonic\IexCloudSdk\Facades\ReferenceData\USExchanges;
use Digitonic\IexCloudSdk\Tests\BaseTestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Collection;

class USExchangesTest extends BaseTestCase
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

        $this->response = new Response(200, [], '[{ "mic": "XARC", "name": "c ErNaSAY", "longName": " EYRACNAS", "tapeId": "P", "oatsId": "PX", "refId": "ESP", "type": "equities" },{ "mic": "EGDX", "name": "EXe oCDbG", "longName": "Sh xbgtEi sGieqUnDEEce oCuae X", "tapeId": "K", "oatsId": "XK", "refId": "GEXD", "type": "equities" }, { "mic": "BSAT","name": "CeBZb oX","longName": " XniaBcs Z  UeuCShtxEbegqieEo", "tapeId": "Z","oatsId": "XZ","refId": "ASBT","type": "equities"}]');
    }

    /** @test */
    public function it_can_query_the_region_symbols_endpoint()
    {
        $mock = new MockHandler([$this->response]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $iexApi = new \Digitonic\IexCloudSdk\Client($client);

        $usExchanges = new \Digitonic\IexCloudSdk\ReferenceData\USExchanges($iexApi);

        $response = $usExchanges->send();
        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(3, $response);
        $this->assertEquals('XARC', $response->first()->mic);
        $this->assertEquals('c ErNaSAY', $response->first()->name);
        $this->assertEquals(' EYRACNAS', $response->first()->longName);
        $this->assertEquals('P', $response->first()->tapeId);
    }

    /** @test */
    public function it_can_call_the_facade()
    {
        $this->setConfig();

        USExchanges::shouldReceive('send')
            ->once()
            ->andReturn(collect(json_decode($this->response->getBody()->getContents())));

        USExchanges::send();
    }
}
