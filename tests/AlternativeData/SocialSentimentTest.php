<?php

namespace Digitonic\IexCloudSdk\Tests\AlternativeData;

use Digitonic\IexCloudSdk\Exceptions\WrongData;
use Digitonic\IexCloudSdk\Facades\AlternativeData\SocialSentiment;
use Digitonic\IexCloudSdk\Tests\BaseTestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Collection;

class SocialSentimentTest extends BaseTestCase
{
    /**
     * @var Response
     */
    private $response;

    /**
     * @var Response
     */
    private $minuteResponse;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->response = new Response(200, [], '{"sentiment": -0.06526978088510728,"totalScores": 358,"positive": 0.72,"negative": 0.31}');

        $this->minuteResponse = new Response(200, [], '[{"sentiment": 0.4723,"totalScores": 2,"positive": 1,"negative": 0,"minute": "0001"},{"sentiment": -0.8075,"totalScores": 1,"positive": 0,"negative": 1,"minute": "0004"},{"sentiment": 0,"totalScores": 1,"positive": 1,"negative": 0,"minute": "0015"}]');
    }

    /** @test */
    public function it_should_fail_without_a_symbol()
    {
        $mock = new MockHandler([$this->response]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $iexApi = new \Digitonic\IexCloudSdk\Client($client);

        $social = new \Digitonic\IexCloudSdk\AlternativeData\SocialSentiment($iexApi);

        $this->expectException(WrongData::class);

        $social->send();
    }

    /** @test */
    public function it_should_fail_for_wrong_date_format()
    {
        $mock = new MockHandler([$this->response]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $iexApi = new \Digitonic\IexCloudSdk\Client($client);

        $social = new \Digitonic\IexCloudSdk\AlternativeData\SocialSentiment($iexApi);

        $this->expectException(WrongData::class);

        $social->setDate('2019-09-30')->setSymbol('aapl')->send();
    }

    /** @test */
    public function it_can_query_the_social_sentiment_endpoint()
    {
        $mock = new MockHandler([$this->response]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $iexApi = new \Digitonic\IexCloudSdk\Client($client);

        $social = new \Digitonic\IexCloudSdk\AlternativeData\SocialSentiment($iexApi);

        $response = $social->setDate('20190930')
            ->setSymbol('aapl')
            ->send();

        $this->assertInstanceOf(Collection::class, $response);

        $response = $response->toArray();
        $this->assertCount(4, $response);
        $this->assertEquals(-0.065269780885107, $response['sentiment']);
        $this->assertEquals(358, $response['totalScores']);
    }

    /** @test */
    public function it_can_query_the_social_sentiment_endpoint_per_minute()
    {
        $mock = new MockHandler([$this->minuteResponse]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $iexApi = new \Digitonic\IexCloudSdk\Client($client);

        $social = new \Digitonic\IexCloudSdk\AlternativeData\SocialSentiment($iexApi);

        $response = $social->setDate('20190930')
            ->setType('minute')
            ->setSymbol('aapl')
            ->send();

        $this->assertInstanceOf(Collection::class, $response);

        $response = $response->toArray();
        $this->assertCount(3, $response);
        $this->assertEquals(0.4723, $response[0]->sentiment);
        $this->assertEquals(2, $response[0]->totalScores);
    }

    /** @test */
    public function it_can_call_the_facade()
    {
        $this->setConfig();

        SocialSentiment::shouldReceive('setSymbol')
            ->once()
            ->andReturnSelf();

        SocialSentiment::setSymbol('aapl');
    }
}
