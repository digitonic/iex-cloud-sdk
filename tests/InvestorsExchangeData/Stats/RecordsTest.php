<?php

namespace Digitonic\IexCloudSdk\Tests\InvestorsExchangeData\Stats;

use Digitonic\IexCloudSdk\Facades\InvestorsExchangeData\Stats\Records;
use Digitonic\IexCloudSdk\Tests\BaseTestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Collection;

class RecordsTest extends BaseTestCase
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

        $this->response = new Response(200, [], '{"volume": {"recordValue": 314011875,"recordDate": "2018-12-24","previousDayValue": 168870290,"avg30Value": 205607018},"symbolsTraded": {"recordValue": 6724,"recordDate": "2019-01-03","previousDayValue": 6076,"avg30Value": 6058},"routedVolume": {"recordValue": 75711728,"recordDate": "2016-11-15","previousDayValue": 21921446,"avg30Value": 27172249},"notional": {"recordValue": 17312351177.095,"recordDate": "2018-02-17","previousDayValue": 7589788889.9959,"avg30Value": 9504675591.4445}}');
    }

    /** @test */
    public function it_can_query_the_deep_trades_endpoint()
    {
        $mock = new MockHandler([$this->response]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $iexApi = new \Digitonic\IexCloudSdk\Client($client);

        $records = new \Digitonic\IexCloudSdk\InvestorsExchangeData\Stats\Records($iexApi);

        $response = $records->send();

        $this->assertInstanceOf(Collection::class, $response);

        $response = $response->toArray();
        $this->assertCount(4, $response);
    }

    /** @test */
    public function it_can_call_the_facade()
    {
        $this->setConfig();

        Records::shouldReceive('send')
            ->once()
            ->andReturn(collect(json_decode($this->response->getBody()->getContents())));

        Records::send();
    }
}
