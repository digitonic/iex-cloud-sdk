<?php

namespace Digitonic\IexCloudSdk\Tests\AlternativeData;

use Digitonic\IexCloudSdk\Exceptions\WrongData;
use Digitonic\IexCloudSdk\Facades\AlternativeData\CeoComp;
use Digitonic\IexCloudSdk\Tests\BaseTestCase;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Collection;

class CeoCompTest extends BaseTestCase
{
    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->response = new Response(200, [], '{"symbol": "AAPL","name": "hCioomyo tkT","companyName": "Apple Inc.","location": "rCpAt Ciu,neo","salary": 3147884,"bonus": 0,"stockAwards": 0,"optionAwards": 0,"nonEquityIncentives": 12511213,"pensionAndDeferred": 0,"otherComp": 694239,"total": 15976116,"year": "2081"}');

        $this->client = $this->setupMockedClient($this->response);
    }

    /** @test */
    public function it_should_fail_without_a_symbol()
    {
        $crypto = new \Digitonic\IexCloudSdk\AlternativeData\CeoComp($this->client);

        $this->expectException(WrongData::class);

        $crypto->get();
    }

    /** @test */
    public function it_can_query_the_ceo_comp_endpoint()
    {
        $crypto = new \Digitonic\IexCloudSdk\AlternativeData\CeoComp($this->client);

        $response = $crypto->setSymbol('aapl')->get();

        $this->assertInstanceOf(Collection::class, $response);

        $response = $response->toArray();
        $this->assertCount(13, $response);
        $this->assertEquals('rCpAt Ciu,neo', $response['location']);
        $this->assertEquals(3147884, $response['salary']);
    }

    /** @test */
    public function it_can_call_the_facade()
    {
        $this->setConfig();

        CeoComp::shouldReceive('setSymbol')
            ->once()
            ->andReturnSelf();

        CeoComp::setSymbol('aapl');
    }
}
