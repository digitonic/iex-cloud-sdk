<?php

namespace Digitonic\IexCloudSdk\Tests\Stocks;

use Digitonic\IexCloudSdk\Exceptions\WrongData;
use Digitonic\IexCloudSdk\Facades\Stocks\VolumeByVenue;
use Digitonic\IexCloudSdk\Tests\BaseTestCase;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Collection;

class VolumeByVenueTest extends BaseTestCase
{
    /**
     * @var \Digitonic\IexCloudSdk\Client
     */
    private $singleClient;

    /**
     * @var Response
     */
    private $singleResponse;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->response = new Response(200, [], '[{
    "volume": 289791,
    "venue": "IEXG",
    "venueName": "IEX",
    "date": "2017-09-19",
    "marketPercent": 0.014105441890783691
  }]');

        $this->client = $this->setupMockedClient($this->response);
    }

    /** @test */
    public function it_should_fail_without_a_symbol()
    {
        $volume = new \Digitonic\IexCloudSdk\Stocks\VolumeByVenue($this->client);

        $this->expectException(WrongData::class);

        $volume->get();
    }

    /** @test */
    public function it_can_query_the_volume_by_venue_endpoint()
    {
        $volume = new \Digitonic\IexCloudSdk\Stocks\VolumeByVenue($this->client);

        $response = $volume->setSymbol('aapl')->get();

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(1, $response);
    }

    /** @test */
    public function it_can_call_the_facade()
    {
        $this->setConfig();

        VolumeByVenue::shouldReceive('setSymbol')
            ->once()
            ->andReturnSelf();

        VolumeByVenue::setSymbol('aapl');
    }
}
