<?php

namespace Digitonic\IexCloudSdk\Tests\ReferenceData;

use Digitonic\IexCloudSdk\Facades\ReferenceData\OptionsSymbols;
use Digitonic\IexCloudSdk\Tests\BaseTestCase;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Collection;

class OptionsSymbolsTest extends BaseTestCase
{
    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->response = new Response(200, [], '{"DDOG": ["203385","205236","211102","205729"],"FLIC": ["210742","204937","211972","202932"]}');

        $this->client = $this->setupMockedClient($this->response);
    }

    /** @test */
    public function it_can_query_the_symbols_endpoint()
    {
        $symbols = new \Digitonic\IexCloudSdk\ReferenceData\OptionsSymbols($this->client);

        $response = $symbols->get();

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(2, $response);
        $response = $response->toArray();

        $this->assertEquals('203385', $response['DDOG'][0]);
        $this->assertEquals('205236', $response['DDOG'][1]);
        $this->assertEquals('211102', $response['DDOG'][2]);
        $this->assertEquals('205729', $response['DDOG'][3]);

        $this->assertEquals('210742', $response['FLIC'][0]);
        $this->assertEquals('204937', $response['FLIC'][1]);
        $this->assertEquals('211972', $response['FLIC'][2]);
        $this->assertEquals('202932', $response['FLIC'][3]);
    }

    /** @test */
    public function it_can_call_the_facade()
    {
        $this->setConfig();

        OptionsSymbols::shouldReceive('get')
            ->once()
            ->andReturn(collect(json_decode($this->response->getBody()->getContents())));

        $response = OptionsSymbols::get();

        $this->assertEquals('203385', $response['DDOG'][0]);
        $this->assertEquals('205236', $response['DDOG'][1]);
        $this->assertEquals('211102', $response['DDOG'][2]);
        $this->assertEquals('205729', $response['DDOG'][3]);
    }
}
