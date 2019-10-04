<?php

namespace Digitonic\IexCloudSdk\Tests\InvestorsExchangeData\Deep;

use Digitonic\IexCloudSdk\Exceptions\WrongData;
use Digitonic\IexCloudSdk\Facades\InvestorsExchangeData\Deep\Book;
use Digitonic\IexCloudSdk\Facades\InvestorsExchangeData\Deep\SecurityEvent;
use Digitonic\IexCloudSdk\Facades\InvestorsExchangeData\Deep\SystemEvent;
use Digitonic\IexCloudSdk\Tests\BaseTestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Collection;

class SystemEventTest extends BaseTestCase
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

        $this->response = new Response(200, [], '{"systemEvent": "C","timestamp": 1617613100686}');
    }

    /** @test */
    public function it_can_query_the_deep_system_event_endpoint()
    {
        $mock = new MockHandler([$this->response]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $iexApi = new \Digitonic\IexCloudSdk\Client($client);

        $systemEvent = new \Digitonic\IexCloudSdk\InvestorsExchangeData\Deep\SystemEvent($iexApi);

        $response = $systemEvent->send();

        $this->assertInstanceOf(Collection::class, $response);

        $response = $response->toArray();
        $this->assertCount(2, $response);
    }

    /** @test */
    public function it_can_call_the_facade()
    {
        $this->setConfig();

        SystemEvent::shouldReceive('send')
            ->once()
            ->andReturn(collect(json_decode($this->response->getBody()->getContents())));

        SystemEvent::send();
    }
}
