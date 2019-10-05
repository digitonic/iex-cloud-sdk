<?php

namespace Digitonic\IexCloudSdk\Tests\InvestorsExchangeData\Deep;

use Digitonic\IexCloudSdk\Exceptions\WrongData;
use Digitonic\IexCloudSdk\Facades\InvestorsExchangeData\Deep\OpHaltStatus;
use Digitonic\IexCloudSdk\Tests\BaseTestCase;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Collection;

class OpHaltStatusTest extends BaseTestCase
{
    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->response = new Response(200, [], '{"SNAP": {"isHalted": false,"timestamp": 1494588017674}}');

        $this->client = $this->setupMockedClient($this->response);
    }

    /** @test */
    public function it_should_fail_without_a_symbol()
    {
        $status = new \Digitonic\IexCloudSdk\InvestorsExchangeData\Deep\OpHaltStatus($this->client);

        $this->expectException(WrongData::class);

        $status->get();
    }

    /** @test */
    public function it_can_query_the_op_halt_status_endpoint()
    {
        $status = new \Digitonic\IexCloudSdk\InvestorsExchangeData\Deep\OpHaltStatus($this->client);

        $response = $status->setSymbols('SNAP')->get();

        $this->assertInstanceOf(Collection::class, $response);

        $response = $response->toArray();
        $this->assertCount(1, $response);
        $this->assertCount(2, (array) $response['SNAP']);
        $this->assertEquals(false, $response['SNAP']->isHalted);
        $this->assertEquals(1494588017674, $response['SNAP']->timestamp);
    }

    /** @test */
    public function it_can_call_the_facade()
    {
        $this->setConfig();

        OpHaltStatus::shouldReceive('setSymbols')
            ->once()
            ->andReturnSelf();

        OpHaltStatus::setSymbols('SNAP');
    }
}
