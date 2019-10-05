<?php

namespace Digitonic\IexCloudSdk\Tests\DataApis\TimeSeries;

use Digitonic\IexCloudSdk\Facades\DataApis\TimeSeries\Inventory;
use Digitonic\IexCloudSdk\Tests\BaseTestCase;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Collection;

class InventoryTest extends BaseTestCase
{
    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->response = new Response(200, [], '[{"id": "TRAECNEOFDPIIRNLA_S","description": "psldnfeiaatre Rcnoi","schema": {"type": "object","properties": {"formFiscalYear": {"type": "number"},"formFiscalQuarter": {"type": "number"},"version": {"type": "string"},"periodStart": {"type": "string"},"periodEnd": {"type": "string"},"dateFiled": {"type": "string"},"reportLink": {"type": "string"}},"required": [],"additionalProperties": true},"weight": 5112,"created": "00-:34302: 62110-49","lastUpdated": "00239:14:0--0 36412"}]');

        $this->client = $this->setupMockedClient($this->response);
    }

    /** @test */
    public function it_can_query_the_time_series_endpoint()
    {
        $timeSeries = new \Digitonic\IexCloudSdk\DataApis\TimeSeries\Inventory($this->client);

        $response = $timeSeries->get();

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(1, $response);
        $this->assertEquals('TRAECNEOFDPIIRNLA_S', $response->first()->id);
        $this->assertEquals(5112, $response->first()->weight);
        $this->assertEquals('00-:34302: 62110-49', $response->first()->created);
    }

    /** @test */
    public function it_can_call_the_facade()
    {
        $this->setConfig();

        Inventory::shouldReceive('get')
            ->once()
            ->andReturn(collect(json_decode($this->response->getBody()->getContents())));

        $response = Inventory::get();

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(1, $response);
        $this->assertEquals('TRAECNEOFDPIIRNLA_S', $response->first()->id);
        $this->assertEquals(5112, $response->first()->weight);
        $this->assertEquals('00-:34302: 62110-49', $response->first()->created);
    }
}
