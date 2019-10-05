<?php

namespace Digitonic\IexCloudSdk\Tests\InvestorsExchangeData\Deep;

use Digitonic\IexCloudSdk\Exceptions\WrongData;
use Digitonic\IexCloudSdk\Facades\InvestorsExchangeData\Deep\SecurityEvent;
use Digitonic\IexCloudSdk\Tests\BaseTestCase;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Collection;

class SecurityEventTest extends BaseTestCase
{
    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->response = new Response(200, [], '{"AAPL": {"securityEvent": "oetlCasrkeM","timestamp": 1616881490142}}');

        $this->client = $this->setupMockedClient($this->response);
    }

    /** @test */
    public function it_should_fail_without_a_symbol()
    {
        $securityEvent = new \Digitonic\IexCloudSdk\InvestorsExchangeData\Deep\SecurityEvent($this->client);

        $this->expectException(WrongData::class);

        $securityEvent->get();
    }

    /** @test */
    public function it_can_query_the_deep_book_endpoint()
    {
        $securityEvent = new \Digitonic\IexCloudSdk\InvestorsExchangeData\Deep\SecurityEvent($this->client);

        $response = $securityEvent->setSymbol('aapl')->get();

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
