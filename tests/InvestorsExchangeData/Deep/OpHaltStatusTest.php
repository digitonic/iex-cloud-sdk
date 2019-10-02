<?php

namespace Digitonic\IexCloudSdk\Tests\InvestorsExchangeData\Deep;

use Digitonic\IexCloudSdk\Exceptions\WrongData;
use Digitonic\IexCloudSdk\Facades\InvestorsExchangeData\Deep\OpHaltStatus;
use Digitonic\IexCloudSdk\Tests\BaseTestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Collection;

class OpHaltStatusTest extends BaseTestCase
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

        $this->response = new Response(200, [], '{"SNAP": {"isHalted": false,"timestamp": 1494588017674}}');
    }

    /** @test */
    public function it_should_fail_without_a_symbol()
    {
        $mock = new MockHandler([$this->response]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $iexApi = new \Digitonic\IexCloudSdk\Client($client);

        $status = new \Digitonic\IexCloudSdk\InvestorsExchangeData\Deep\OpHaltStatus($iexApi);

        $this->expectException(WrongData::class);

        $status->send();
    }

    /** @test */
    public function it_can_query_the_op_halt_status_endpoint()
    {
        $mock = new MockHandler([$this->response]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $iexApi = new \Digitonic\IexCloudSdk\Client($client);

        $status = new \Digitonic\IexCloudSdk\InvestorsExchangeData\Deep\OpHaltStatus($iexApi);

        $response = $status->setSymbols('SNAP')->send();

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
        $this->app['config']->set('iex-cloud-sdk.base_url', 'https://cloud.iexapis.com/v1');
        $this->app['config']->set('iex-cloud-sdk.secret_key', 'KxDMt9GNVgu6fJUOG0UjH3d4kjZPTxFiXd5RnPhUD8Qz1Q2esNVIFfqmrqRD');
        $this->app['config']->set('iex-cloud-sdk.public_key', 'KxDMt9GNVgu6fJUOG0UjH3d4kjZPTxFiXd5RnPhUD8Qz1Q2esNVIFfqmrqRD');

        OpHaltStatus::shouldReceive('setSymbols')
            ->once()
            ->andReturnSelf();

        OpHaltStatus::setSymbols('SNAP');
    }
}
