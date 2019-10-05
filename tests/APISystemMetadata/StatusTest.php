<?php

namespace Digitonic\IexCloudSdk\Tests\APISystemMetadata;

use Digitonic\IexCloudSdk\Facades\APISystemMetadata\Status;
use Digitonic\IexCloudSdk\Tests\BaseTestCase;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Collection;

class StatusTest extends BaseTestCase
{
    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->response = new Response(200, [], '{"status": "up","version": "1.9","time": 1569418156693}');

        $this->client = $this->setupMockedClient($this->response);
    }

    /** @test */
    public function it_can_query_the_status_endpoint()
    {
        $status = new \Digitonic\IexCloudSdk\APISystemMetadata\Status($this->client);

        $response = $status->get();

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(3, $response);
        $this->assertEquals('up', $response['status']);
    }

    /** @test */
    public function it_can_call_the_facade()
    {
        $this->setConfig();

        Status::shouldReceive('get')
            ->once()
            ->andReturn(collect(json_decode($this->response->getBody()->getContents())));

        $response = Status::get();

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(3, $response);
        $this->assertEquals('up', $response['status']);

    }
}
