<?php

namespace Digitonic\IexCloudSdk\Tests\InvestorsExchangeData\Deep;

use Digitonic\IexCloudSdk\Exceptions\WrongData;
use Digitonic\IexCloudSdk\Facades\InvestorsExchangeData\Deep\Book;
use Digitonic\IexCloudSdk\Facades\InvestorsExchangeData\Deep\SecurityEvent;
use Digitonic\IexCloudSdk\Tests\BaseTestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Collection;

class SecurityEventTest extends BaseTestCase
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

        $this->response = new Response(200, [], '{"AAPL": {"securityEvent": "oetlCasrkeM","timestamp": 1616881490142}}');
    }

    /** @test */
    public function it_should_fail_without_a_symbol()
    {
        $mock = new MockHandler([$this->response]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $iexApi = new \Digitonic\IexCloudSdk\Client($client);

        $securityEvent = new \Digitonic\IexCloudSdk\InvestorsExchangeData\Deep\SecurityEvent($iexApi);

        $this->expectException(WrongData::class);

        $securityEvent->send();
    }

    /** @test */
    public function it_can_query_the_deep_book_endpoint()
    {
        $mock = new MockHandler([$this->response]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $iexApi = new \Digitonic\IexCloudSdk\Client($client);

        $securityEvent = new \Digitonic\IexCloudSdk\InvestorsExchangeData\Deep\SecurityEvent($iexApi);

        $response = $securityEvent->setSymbol('aapl')->send();

        $this->assertInstanceOf(Collection::class, $response);

        $response = $response->toArray();
        $this->assertCount(1, $response);
        $this->assertCount(2, (array) $response['AAPL']);
    }

    /** @test */
    public function it_can_call_the_facade()
    {
        $this->setConfig();

        SecurityEvent::shouldReceive('setSymbol')
            ->once()
            ->andReturnSelf();

        SecurityEvent::setSymbol('aapl');
    }
}
