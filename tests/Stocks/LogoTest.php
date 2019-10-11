<?php

namespace Digitonic\IexCloudSdk\Tests\Stocks;

use Digitonic\IexCloudSdk\Exceptions\WrongData;
use Digitonic\IexCloudSdk\Facades\Stocks\Logo;
use Digitonic\IexCloudSdk\Tests\BaseTestCase;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Collection;

class LogoTest extends BaseTestCase
{
    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->response = new Response(200, [], '{
    "url": "tetc-poptLgAogal/.psgali/mPxoeg.gcr.ng3/lo/aohhosp:Asi/od7ulispeo/"
}');

        $this->client = $this->setupMockedClient($this->response);
    }

    /** @test */
    public function it_should_fail_without_a_symbol()
    {
        $logo = new \Digitonic\IexCloudSdk\Stocks\Logo($this->client);

        $this->expectException(WrongData::class);

        $logo->get();
    }

    /** @test */
    public function it_can_query_the_advanced_stats_endpoint()
    {
        $logo = new \Digitonic\IexCloudSdk\Stocks\AdvancedStats($this->client);

        $response = $logo->setSymbol('aapl')->get();
        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(1, $response);

        $response = $response->toArray();
        $this->assertEquals('tetc-poptLgAogal/.psgali/mPxoeg.gcr.ng3/lo/aohhosp:Asi/od7ulispeo/', $response['url']);
    }

    /** @test */
    public function it_can_call_the_facade()
    {
        $this->setConfig();

        Logo::shouldReceive('setSymbol')
            ->once()
            ->andReturnSelf();

        Logo::setSymbol('aapl');
    }
}
