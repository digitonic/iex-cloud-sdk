<?php

namespace Digitonic\IexCloudSdk\Tests\InvestorsExchangeData\Deep;

use Digitonic\IexCloudSdk\Exceptions\WrongData;
use Digitonic\IexCloudSdk\Facades\InvestorsExchangeData\Deep\TradeBreak;
use Digitonic\IexCloudSdk\Tests\BaseTestCase;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Collection;

class TradeBreakTest extends BaseTestCase
{
    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->response = new Response(200, [], '{"SNAP": [{"price": 156.1,"size": 100,"tradeId": 517341294,"isISO": false,"isOddLot": false,"isOutsideRegularHours": false,"isSinglePriceCross": false,"isTradeThroughExempt": false,"timestamp": 1494619192003}]}');

        $this->client = $this->setupMockedClient($this->response);
    }

    /** @test */
    public function it_should_fail_without_a_symbol()
    {
        $tradeBreak = new \Digitonic\IexCloudSdk\InvestorsExchangeData\Deep\TradeBreak($this->client);

        $this->expectException(WrongData::class);

        $tradeBreak->get();
    }

    /** @test */
    public function it_should_fail_when_last_is_greater_than_500()
    {
        $tradeBreak = new \Digitonic\IexCloudSdk\InvestorsExchangeData\Deep\TradeBreak($this->client);

        $this->expectException(WrongData::class);

        $tradeBreak->setLast(1000)->setSymbols('SNAP')->get();
    }

    /** @test */
    public function it_can_query_the_deep_trade_break_endpoint()
    {
        $tradeBreak = new \Digitonic\IexCloudSdk\InvestorsExchangeData\Deep\TradeBreak($this->client);

        $response = $tradeBreak->setLast(100)->setSymbols('SNAP')->get();

        $this->assertInstanceOf(Collection::class, $response);

        $response = $response->toArray();
        $this->assertCount(1, $response);
        $this->assertCount(9, (array) $response['SNAP'][0]);
    }

    /** @test */
    public function it_can_call_the_facade()
    {
        $this->setConfig();

        TradeBreak::shouldReceive('setSymbol')
            ->once()
            ->andReturnSelf();

        TradeBreak::setSymbol('SNAP');
    }
}
