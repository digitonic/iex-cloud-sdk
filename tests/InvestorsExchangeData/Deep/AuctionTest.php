<?php

namespace Digitonic\IexCloudSdk\Tests\InvestorsExchangeData\Deep;

use Digitonic\IexCloudSdk\Exceptions\WrongData;
use Digitonic\IexCloudSdk\Facades\InvestorsExchangeData\Deep\Auction;
use Digitonic\IexCloudSdk\Tests\BaseTestCase;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Collection;

class AuctionTest extends BaseTestCase
{
    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->response = new Response(200, [], '{"ZIEXT": {"auctionType": "Cselo","pairedShares": 2077,"imbalanceShares": 0,"imbalanceSide": "onNe","referencePrice": 1,"indicativePrice": 1,"auctionBookPrice": 1,"collarReferencePrice": 1,"lowerCollarPrice": 0.5,"upperCollarPrice": 1.6,"extensionNumber": 0,"startTime": 1618463118591,"timestamp": 1605746824585}}');

        $this->client = $this->setupMockedClient($this->response);
    }

    /** @test */
    public function it_should_fail_without_a_symbol()
    {
        $auction = new \Digitonic\IexCloudSdk\InvestorsExchangeData\Deep\Auction($this->client);

        $this->expectException(WrongData::class);

        $auction->get();
    }

    /** @test */
    public function it_can_query_the_auction_endpoint()
    {
        $auction = new \Digitonic\IexCloudSdk\InvestorsExchangeData\Deep\Auction($this->client);

        $response = $auction->setSymbol('ZIEXT')->get();

        $this->assertInstanceOf(Collection::class, $response);

        $response = $response->toArray();
        $this->assertCount(1, $response);
        $this->assertCount(13, (array) $response['ZIEXT']);
        $this->assertEquals('Cselo', $response['ZIEXT']->auctionType);
        $this->assertEquals(2077, $response['ZIEXT']->pairedShares);
        $this->assertEquals('onNe', $response['ZIEXT']->imbalanceSide);
    }

    /** @test */
    public function it_can_call_the_facade()
    {
        $this->setConfig();

        Auction::shouldReceive('setSymbol')
            ->once()
            ->andReturnSelf();

        Auction::setSymbol('aapl');
    }
}
