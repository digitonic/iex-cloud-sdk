<?php

namespace Digitonic\IexCloudSdk\Tests\ReferenceData;

use Digitonic\IexCloudSdk\Exceptions\WrongData;
use Digitonic\IexCloudSdk\Facades\ReferenceData\USHolTradeDates;
use Digitonic\IexCloudSdk\Tests\BaseTestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class USHolTradeDatesTest extends BaseTestCase
{
    /**
     * @var Response
     */
    private $response;

    /**
     * @var Response
     */
    private $defaultResponse;

    /**
     * @var Response
     */
    private $holidayResponse;

    /**
     * @var Response
     */
    private $holidayResponse5;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->defaultResponse = new Response(200, [], '[{"date": "2019-10-07","settlementDate": "2019-10-17"}]');
        $this->holidayResponse = new Response(200, [], '[{"date": "2019-11-28","settlementDate": "2019-12-16"}]');
        $this->holidayResponse5 = new Response(200, [], '[{"date": "2019-11-28","settlementDate": "2019-12-09" },{"date": "2019-12-25","settlementDate": "2019-12-30"},{"date": "2020-01-01", "settlementDate": "2020-01-04" },{"date": "2020-01-20","settlementDate": "2020-01-26"},{"date": "2020-02-17", "settlementDate": "2020-03-05"}]');
    }

    /** @test */
    public function it_should_fail_when_type_not_matching_available()
    {
        $mock = new MockHandler([$this->defaultResponse]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $iexApi = new \Digitonic\IexCloudSdk\Client($client);

        $usHolTradeDates = new \Digitonic\IexCloudSdk\ReferenceData\USHolTradeDates($iexApi);

        $this->expectException(WrongData::class);

        $usHolTradeDates->setType('blah')->send();
    }

    /** @test */
    public function it_should_fail_when_direction_not_matching_available()
    {
        $mock = new MockHandler([$this->defaultResponse]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $iexApi = new \Digitonic\IexCloudSdk\Client($client);

        $usHolTradeDates = new \Digitonic\IexCloudSdk\ReferenceData\USHolTradeDates($iexApi);

        $this->expectException(WrongData::class);

        $usHolTradeDates->setDirection('blah')->send();
    }

    /** @test */
    public function it_can_query_the_default_us_holiday_trades_date_symbols_endpoint()
    {
        $mock = new MockHandler([$this->defaultResponse]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $iexApi = new \Digitonic\IexCloudSdk\Client($client);

        $usHolTradeDates = new \Digitonic\IexCloudSdk\ReferenceData\USHolTradeDates($iexApi);

        $response = $usHolTradeDates->setDirection('last')->send();

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(1, $response);
        $this->assertEquals('2019-10-07', $response->first()->date);
        $this->assertEquals('2019-10-17', $response->first()->settlementDate);
    }

    /** @test */
    public function it_can_query_the_holiday_us_holiday_trades_date_symbols_endpoint()
    {
        $mock = new MockHandler([$this->holidayResponse]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $iexApi = new \Digitonic\IexCloudSdk\Client($client);

        $usHolTradeDates = new \Digitonic\IexCloudSdk\ReferenceData\USHolTradeDates($iexApi);

        $response = $usHolTradeDates->setType('holiday')->send();

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(1, $response);
        $this->assertEquals('2019-11-28', $response->first()->date);
        $this->assertEquals('2019-12-16', $response->first()->settlementDate);
    }

    /** @test */
    public function it_can_query_the_holiday_us_holiday_trades_date_symbols_endpoint_with_5_last_set()
    {
        $mock = new MockHandler([$this->holidayResponse5]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $iexApi = new \Digitonic\IexCloudSdk\Client($client);

        $usHolTradeDates = new \Digitonic\IexCloudSdk\ReferenceData\USHolTradeDates($iexApi);

        $response = $usHolTradeDates->setType('holiday')->setLast(5)->send();

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(5, $response);
        $this->assertEquals('2019-11-28', $response->first()->date);
        $this->assertEquals('2019-12-09', $response->first()->settlementDate);
    }

    /** @test */
    public function it_can_specify_a_start_date()
    {
        $mock = new MockHandler([$this->holidayResponse]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $iexApi = new \Digitonic\IexCloudSdk\Client($client);

        $usHolTradeDates = new \Digitonic\IexCloudSdk\ReferenceData\USHolTradeDates($iexApi);

        $response = $usHolTradeDates->setType('holiday')->setStartDate('20191003')->send();

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(1, $response);

        $returnedDate = Carbon::parse($response->first()->date);
        $startDate = Carbon::parse('20191003');

        $this->assertGreaterThan($startDate, $returnedDate);
    }

    /** @test */
    public function it_validates_correct_date_format()
    {
        $mock = new MockHandler([$this->holidayResponse]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $iexApi = new \Digitonic\IexCloudSdk\Client($client);

        $usHolTradeDates = new \Digitonic\IexCloudSdk\ReferenceData\USHolTradeDates($iexApi);

        $this->expectException(WrongData::class);

        $usHolTradeDates->setStartDate('2019-10-03')->send();
    }

    /** @test */
    public function it_can_call_the_facade()
    {
        $this->setConfig();

        USHolTradeDates::shouldReceive('setType')
            ->once()
            ->andReturnSelf();

        USHolTradeDates::setType('next');
    }
}
