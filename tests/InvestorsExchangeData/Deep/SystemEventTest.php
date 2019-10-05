<?php

namespace Digitonic\IexCloudSdk\Tests\InvestorsExchangeData\Deep;

use Digitonic\IexCloudSdk\Facades\InvestorsExchangeData\Deep\SystemEvent;
use Digitonic\IexCloudSdk\Tests\BaseTestCase;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Collection;

class SystemEventTest extends BaseTestCase
{
    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->response = new Response(200, [], '{"systemEvent": "C","timestamp": 1617613100686}');

        $this->client = $this->setupMockedClient($this->response);
    }

    /** @test */
    public function it_can_query_the_deep_system_event_endpoint()
    {
        $systemEvent = new \Digitonic\IexCloudSdk\InvestorsExchangeData\Deep\SystemEvent($this->client);

        $response = $systemEvent->get();

        $this->assertInstanceOf(Collection::class, $response);

        $response = $response->toArray();
        $this->assertCount(2, $response);
    }

    /** @test */
    public function it_can_call_the_facade()
    {
        $this->setConfig();

        SystemEvent::shouldReceive('get')
            ->once()
            ->andReturn(collect(json_decode($this->response->getBody()->getContents())));

        SystemEvent::get();
    }
}
