<?php

namespace Digitonic\IexCloudSdk\Tests\APISystemMetadata;

use Digitonic\IexCloudSdk\Facades\APISystemMetadata\Status;
use Digitonic\IexCloudSdk\Tests\BaseTestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Collection;

class StatusTest extends BaseTestCase
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

        $this->response = new Response(200, [], '{"status": "up","version": "1.9","time": 1569418156693}');
    }

    /** @test */
    public function it_can_query_the_status_endpoint()
    {
        $mock = new MockHandler([$this->response]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $iexApi = new \Digitonic\IexCloudSdk\Client($client);

        $status = new \Digitonic\IexCloudSdk\APISystemMetadata\Status($iexApi);

        $response = $status->send();

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(3, $response);
        $this->assertEquals('up', $response['status']);
    }

    /** @test */
    public function it_can_call_the_facade()
    {
        $this->app['config']->set('iex-cloud-sdk.base_url', 'https://cloud.iexapis.com/v1');
        $this->app['config']->set('iex-cloud-sdk.secret_key', 'KxDMt9GNVgu6fJUOG0UjH3d4kjZPTxFiXd5RnPhUD8Qz1Q2esNVIFfqmrqRD');
        $this->app['config']->set('iex-cloud-sdk.public_key', 'KxDMt9GNVgu6fJUOG0UjH3d4kjZPTxFiXd5RnPhUD8Qz1Q2esNVIFfqmrqRD');

        Status::shouldReceive('send')
            ->once()
            ->andReturn(collect(json_decode($this->response->getBody()->getContents())));

        $response = Status::send();

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(3, $response);
        $this->assertEquals('up', $response['status']);

    }
}
