<?php

namespace Digitonic\IexCloudSdk\Tests\Stocks;

use Digitonic\IexCloudSdk\Exceptions\WrongData;
use Digitonic\IexCloudSdk\Facades\Stocks\BalanceSheet;
use Digitonic\IexCloudSdk\Tests\BaseTestCase;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Collection;

class BalanceSheetTest extends BaseTestCase
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
    "symbol": "AAPL",
    "balancesheet": [
        {
            "reportDate": "2019-07-04",
            "currentCash": 52963215462,
            "shortTermInvestments": 45284842217,
            "receivables": 14503331005,
            "inventory": 3477122772,
            "otherCurrentAssets": 10292009468,
            "currentAssets": 136568447561,
            "longTermInvestments": 118651798346,
            "propertyPlantEquipment": 37693451764,
            "goodwill": 0,
            "intangibleAssets": null,
            "otherAssets": 32723695415,
            "totalAssets": 334648768842,
            "accountsPayable": 29631621325,
            "currentLongTermDebt": 13685498091,
            "otherCurrentLiabilities": 37236387829,
            "totalCurrentLiabilities": 90430501240,
            "longTermDebt": 87524693375,
            "otherLiabilities": 5837049316,
            "minorityInterest": 0,
            "totalLiabilities": 233778832161,
            "commonStock": 4751106009,
            "retainedEarnings": 56395212187,
            "treasuryStock": null,
            "capitalSurplus": null,
            "shareholderEquity": 100531443334,
            "netTangibleAssets": 97707159373
        }
    ]
}');
        $this->client = $this->setupMockedClient($this->response);
    }

    /** @test */
    public function it_should_fail_without_a_symbol()
    {
        $balanceSheet = new \Digitonic\IexCloudSdk\Stocks\BalanceSheet($this->client);

        $this->expectException(WrongData::class);

        $balanceSheet->get();
    }

    /** @test */
    public function it_can_query_the_advanced_stats_endpoint()
    {
        $balanceSheet = new \Digitonic\IexCloudSdk\Stocks\BalanceSheet($this->client);

        $response = $balanceSheet->setSymbol('aapl')->get();

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(2, $response);
        $this->assertEquals('AAPL', $response['symbol']);

        $response = $response->toArray();
        $this->assertEquals('2019-07-04', $response['balancesheet'][0]->reportDate);
        $this->assertEquals(45284842217, $response['balancesheet'][0]->shortTermInvestments);
        $this->assertEquals(3477122772, $response['balancesheet'][0]->inventory);
        $this->assertEquals(0, $response['balancesheet'][0]->goodwill);
    }

    /** @test */
    public function it_can_call_the_facade()
    {
        $this->setConfig();

        BalanceSheet::shouldReceive('setSymbol')
            ->once()
            ->andReturnSelf();

        BalanceSheet::setSymbol('aapl');
    }
}
