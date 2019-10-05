<?php

namespace Digitonic\IexCloudSdk\Tests\InvestorsExchangeData\Stats;

use Digitonic\IexCloudSdk\Facades\InvestorsExchangeData\Stats\Records;
use Digitonic\IexCloudSdk\Tests\BaseTestCase;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Collection;

class RecordsTest extends BaseTestCase
{
    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->response = new Response(200, [], '{"volume": {"recordValue": 314011875,"recordDate": "2018-12-24","previousDayValue": 168870290,"avg30Value": 205607018},"symbolsTraded": {"recordValue": 6724,"recordDate": "2019-01-03","previousDayValue": 6076,"avg30Value": 6058},"routedVolume": {"recordValue": 75711728,"recordDate": "2016-11-15","previousDayValue": 21921446,"avg30Value": 27172249},"notional": {"recordValue": 17312351177.095,"recordDate": "2018-02-17","previousDayValue": 7589788889.9959,"avg30Value": 9504675591.4445}}');

        $this->client = $this->setupMockedClient($this->response);
    }

    /** @test */
    public function it_can_query_the_deep_trades_endpoint()
    {
        $records = new \Digitonic\IexCloudSdk\InvestorsExchangeData\Stats\Records($this->client);

        $response = $records->get();

        $this->assertInstanceOf(Collection::class, $response);

        $response = $response->toArray();
        $this->assertCount(4, $response);
    }

    /** @test */
    public function it_can_call_the_facade()
    {
        $this->setConfig();

        Records::shouldReceive('get')
            ->once()
            ->andReturn(collect(json_decode($this->response->getBody()->getContents())));

        Records::get();
    }
}
