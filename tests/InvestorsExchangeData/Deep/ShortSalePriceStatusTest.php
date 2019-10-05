<?php

namespace Digitonic\IexCloudSdk\Tests\InvestorsExchangeData\Deep;

use Digitonic\IexCloudSdk\Exceptions\WrongData;
use Digitonic\IexCloudSdk\Facades\InvestorsExchangeData\Deep\SsrStatus;
use Digitonic\IexCloudSdk\Tests\BaseTestCase;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Collection;

class ShortSalePriceStatusTest extends BaseTestCase
{
    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->response = new Response(200, [], '{"SNAP": {"isSSR": true,"detail": "N","timestamp": 1494588094067}}');

        $this->client = $this->setupMockedClient($this->response);
    }

    /** @test */
    public function it_should_fail_without_a_symbol()
    {
        $status = new \Digitonic\IexCloudSdk\InvestorsExchangeData\Deep\SsrStatus($this->client);

        $this->expectException(WrongData::class);

        $status->get();
    }

    /** @test */
    public function it_can_query_the_ssr_status_endpoint()
    {
        $status = new \Digitonic\IexCloudSdk\InvestorsExchangeData\Deep\SsrStatus($this->client);

        $response = $status->setSymbols('SNAP')->get();

        $this->assertInstanceOf(Collection::class, $response);

        $response = $response->toArray();
        $this->assertCount(1, $response);
        $this->assertCount(3, (array) $response['SNAP']);
        $this->assertEquals(true, $response['SNAP']->isSSR);
        $this->assertEquals("N", $response['SNAP']->detail);
        $this->assertEquals(1494588094067, $response['SNAP']->timestamp);
    }

    /** @test */
    public function it_can_call_the_facade()
    {
        $this->setConfig();

        SsrStatus::shouldReceive('setSymbols')
            ->once()
            ->andReturnSelf();

        SsrStatus::setSymbols('SNAP');
    }
}
