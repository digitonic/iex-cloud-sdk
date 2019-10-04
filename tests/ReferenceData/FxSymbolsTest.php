<?php

namespace Digitonic\IexCloudSdk\Tests\ReferenceData;

use Digitonic\IexCloudSdk\Facades\ReferenceData\FxSymbols;
use Digitonic\IexCloudSdk\Tests\BaseTestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Collection;

class FxSymbolsTest extends BaseTestCase
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

        $this->response = new Response(200, [], '{"currencies": [{"code": "URE","name": "uoEr"},{"code": "SDU","name": "ll DoaSU.r."}],"pairs": [{"fromCurrency": "REU","toCurrency": "SUD"},{"fromCurrency": "DUS","toCurrency": "URE"},{"fromCurrency": "BPG","toCurrency": "DUS"}]}');
    }

    /** @test */
    public function it_can_query_the_symbols_endpoint()
    {
        $mock = new MockHandler([$this->response]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $iexApi = new \Digitonic\IexCloudSdk\Client($client);

        $symbols = new \Digitonic\IexCloudSdk\ReferenceData\FxSymbols($iexApi);

        $response = $symbols->send();

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(2, $response);
        $response = $response->toArray();

        $this->assertEquals('URE', $response['currencies'][0]->code);
        $this->assertEquals('uoEr', $response['currencies'][0]->name);
        $this->assertEquals('REU', $response['pairs'][0]->fromCurrency);
        $this->assertEquals('SUD', $response['pairs'][0]->toCurrency);

    }

    /** @test */
    public function it_can_call_the_facade()
    {
        $this->setConfig();

        FxSymbols::shouldReceive('send')
            ->once()
            ->andReturn(collect(json_decode($this->response->getBody()->getContents())));

        $response = FxSymbols::send();

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(2, $response);

        $response = $response->toArray();
        $this->assertEquals('URE', $response['currencies'][0]->code);
        $this->assertEquals('uoEr', $response['currencies'][0]->name);
        $this->assertEquals('REU', $response['pairs'][0]->fromCurrency);
        $this->assertEquals('SUD', $response['pairs'][0]->toCurrency);

    }
}
