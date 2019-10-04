<?php

namespace Digitonic\IexCloudSdk\Tests\DataApis\TimeSeries;

use Digitonic\IexCloudSdk\Exceptions\WrongData;
use Digitonic\IexCloudSdk\Facades\DataApis\TimeSeries\Query;
use Digitonic\IexCloudSdk\Tests\BaseTestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Collection;

class QueryTest extends BaseTestCase
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

        $this->response = new Response(200, [], '[{ "id": "SPTIRCANEEIRFO_NDAL", "source": "ECS", "key": "AAPL", "subkey": "1-K0", "updated": 1569505823, "AccountsPayableCurrent": 5672782018, "formFiscalYear": 2018, "version": "ps-agau", "periodStart": 1256999533413,"periodEnd": 1272694912711,"dateFiled": 1284417047317,"formFiscalQuarter": null,"reportLink": "1/5a:290ov/3s5g.ds.92g1acr39v0ww14a0t0//01/tce/90d00p0thAriew23h81s/e/", "AccountsReceivableNetCurrent": 3407999422,"AccruedLiabilitiesCurrent": 3443628891,"AccumulatedOtherComprehensiveIncomeLossNetOfTax": 86116377,"AdjustmentsToAdditionalPaidInCapitalSharebasedCompensationRequisiteServicePeriodRecognitionValue": 728348578,"AdjustmentsToAdditionalPaidInCapitalTaxEffectFromShareBasedCompensation": -80621662,"AllowanceForDoubtfulAccountsReceivableCurrent": 54400926,"Assets": 54637083850,"AssetsCurrent": 37725506180,"AvailableForSaleSecuritiesCurrent": 18263895280,"AvailableForSaleSecuritiesNoncurrent": 10702103850,"CashAndCashEquivalentsAtCarryingValue": 5345164830,"CashAndCashEquivalentsPeriodIncreaseDecrease": -6862008760,"CommonStockNoParValue": 0,"CommonStockSharesAuthorized": 1807921946,"CommonStockSharesIssued": 936260331,"CommonStockSharesOutstanding": 901968391,"CommonStockValue": 8535055615,"ComprehensiveIncomeNetOfTax": 6007377407,"CostOfGoodsAndServicesSold": 23787587965,"CumulativeEffectOfInitialAdoptionOfNewAccountingPrinciple": 56086026,"DeferredIncomeTaxExpenseBenefit": -544387450,"DeferredRevenueCurrent": 10421910048,"DeferredRevenueNoncurrent": 4504736749,"DeferredTaxAssetsNetCurrent": 2204505056,"DepreciationAmortizationAndAccretionNet": 715332237,"EarningsPerShareBasic": 6.4,"EarningsPerShareDiluted": 6.48, "EmployeeServiceShareBasedCompensationCashFlowEffectCashUsedToSettleAwards": -84290382,"EntityCommonStockSharesOutstanding": 906610592,"EntityPublicFloat": 97889264026,"ExcessTaxBenefitFromShareBasedCompensationFinancingActivities": 270374626,"GainLossOnSaleOfPropertyPlantEquipment": -26493425,"Goodwill": 212392598,"GrossProfit": 13266139110,"IncomeLossFromContinuingOperationsBeforeIncomeTaxesMinorityInterestAndIncomeLossFromEquityMethodInvestments": 8348413858,"IncomeTaxesPaidNet": 3100967461,"IncomeTaxExpenseBenefit": 2359625968,"IncreaseDecreaseInAccountsPayable": 93515664,"IncreaseDecreaseInAccountsReceivable": 963957298,"IncreaseDecreaseInDeferredRevenue": 7150059367,"IncreaseDecreaseInInventories": -54645632,"IncreaseDecreaseInOtherOperatingAssets": 1357592418,"IncreaseDecreaseInOtherOperatingLiabilities": -184802573,"IncreaseDecreaseOtherCurrentAssets": 1094826256,"IntangibleAssetsNetExcludingGoodwill": 253731726,"InventoryNet": 477431463,"Liabilities": 27083803843,"LiabilitiesAndStockholdersEquity": 55904805808,"LiabilitiesCurrent": 20159596338,"NetCashProvidedByUsedInFinancingActivities": 692658332,"NetCashProvidedByUsedInInvestingActivities": -18182480409,"NetCashProvidedByUsedInOperatingActivities": 10547369714,"NetIncomeLoss": 5762650784,"NonoperatingIncomeExpense": 338689869, "OperatingExpenses": 5643129252,"OperatingIncomeLoss": 7794531035, "OtherAssetsCurrent": 7163715350,"OtherAssetsNoncurrent": 3769758202,"OtherComprehensiveIncomeAvailableForSaleSecuritiesAdjustmentNetOfTaxPeriodIncreaseDecrease": 120614774,"OtherComprehensiveIncomeDerivativesQualifyingAsHedgesNetOfTaxPeriodIncreaseDecrease": 12307876,"OtherComprehensiveIncomeForeignCurrencyTransactionAndTranslationAdjustmentNetOfTaxPeriodIncreaseDecrease": -56523442,"OtherLiabilitiesNoncurrent": 2304554632,"PaymentsForProceedsFromOtherInvestingActivities": 75811809,"PaymentsToAcquireAvailableForSaleSecurities": 46825536002,"PaymentsToAcquireBusinessesNetOfCashAcquired": 0,"PaymentsToAcquireIntangibleAssets": 69285681,"PaymentsToAcquireOtherInvestments": 103283592,"PaymentsToAcquireProductiveAssets": 1153314092,"ProceedsFromIssuanceOfCommonStock": 490754937,"ProceedsFromMaturitiesPrepaymentsAndCallsOfAvailableForSaleSecurities": 20424436578,"ProceedsFromSaleOfAvailableForSaleSecurities": 11407888985,"PropertyPlantAndEquipmentAndCapitalizedSoftwareNet": 3019058999,"ResearchAndDevelopmentExpense": 1371816813,"RetainedEarningsAccumulatedDeficit": 19546381292,"SalesRevenueNet": 37945766358,"SellingGeneralAndAdministrativeExpense": 4251557318,"ShareBasedCompensation": 723376192,"StockholdersEquity": 28663449976,"StockIssuedDuringPeriodValueAcquisitions": 21665003,"StockIssuedDuringPeriodValueShareBasedCompensation": 398277641,"WeightedAverageNumberOfDilutedSharesOutstanding": 936814549,"WeightedAverageNumberOfSharesOutstandingBasic": 894819845},{"id": "OIPDFINRANL_ERAETCS","source": "ECS","key": "PLAA","subkey": "A01K-/","updated": 1569119848,"AccountsPayableCurrent": 5757186699,"formFiscalYear": 2035,"version": "121120009191-05-0310","periodStart": 1299776934250,"periodEnd": 1268771258412,"dateFiled": 1288573864464,"formFiscalQuarter": null,"reportLink": "d0/w32sc0:/g01/ae.1ht0wai000t00c3//91/t1arwpg20d1o/ves1A/r39e920vhs.51","AccountsReceivableNetCurrent": 3486298496,"AccruedLiabilitiesCurrent": 3955191483,"AccumulatedOtherComprehensiveIncomeLossNetOfTax": 78602430,"AdjustmentsToAdditionalPaidInCapitalSharebasedCompensationRequisiteServicePeriodRecognitionValue": 722071154,"AdjustmentsToAdditionalPaidInCapitalTaxEffectFromShareBasedCompensation": -80990712,"AllowanceForDoubtfulAccountsReceivableCurrent": 53930600,"Assets": 47754979818,"AssetsCurrent": 31698484019,"AvailableForSaleSecuritiesCurrent": 18300279920,"AvailableForSaleSecuritiesNoncurrent": 10698978976,"CashAndCashEquivalentsAtCarryingValue": 5317338137,"CashAndCashEquivalentsPeriodIncreaseDecrease": -6776518701,"CommonStockNoParValue": 0,"CommonStockSharesAuthorized": 1805052420,"CommonStockSharesIssued": 921192377,"CommonStockSharesOutstanding": 903965454,"CommonStockValue": 8424215305,"ComprehensiveIncomeNetOfTax": 8711008906,"CostOfGoodsAndServicesSold": 26555489545,"CumulativeEffectOfInitialAdoptionOfNewAccountingPrinciple": 57087576,"DeferredIncomeTaxExpenseBenefit": 1044354677,"DeferredRevenueCurrent": 2074371344,"DeferredRevenueNoncurrent": 887589972,"DeferredTaxAssetsNetCurrent": 1165791963,"DepreciationAmortizationAndAccretionNet": 738327095,"IncreaseDecreaseOtherCurrentAssets": -749163131,"PropertyPlantAndEquipmentAndCapitalizedSoftwareNet": 3010912029}]');
    }

    /** @test */
    public function it_should_throw_exception_for_missing_query_id()
    {
        $mock = new MockHandler([$this->response]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $iexApi = new \Digitonic\IexCloudSdk\Client($client);

        $timeSeriesQuery = new \Digitonic\IexCloudSdk\DataApis\TimeSeries\Query($iexApi);

        $this->expectException(WrongData::class);

        $timeSeriesQuery->setId('REPORTED_FINANCIALS')->send();
    }

    /** @test */
    public function it_should_throw_exception_for_missing_query_key()
    {
        $mock = new MockHandler([$this->response]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $iexApi = new \Digitonic\IexCloudSdk\Client($client);

        $timeSeriesQuery = new \Digitonic\IexCloudSdk\DataApis\TimeSeries\Query($iexApi);

        $this->expectException(WrongData::class);

        $timeSeriesQuery->send();
    }

    /** @test */
    public function it_can_query_the_time_series_query_endpoint()
    {
        $mock = new MockHandler([$this->response]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $iexApi = new \Digitonic\IexCloudSdk\Client($client);

        $timeSeriesQuery = new \Digitonic\IexCloudSdk\DataApis\TimeSeries\Query($iexApi);

        $response = $timeSeriesQuery
            ->setId('REPORTED_FINANCIALS')
            ->setKey('AAPL')
            ->setSubKey('10-Q')
            ->send();

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(2, $response);
        $this->assertEquals('AAPL', $response->first()->key);
        $this->assertEquals('ECS', $response->first()->source);
    }

    /** @test */
    public function it_can_call_the_facade()
    {
        $this->setConfig();

        Query::shouldReceive('setId')
            ->once()
            ->andReturnSelf();

        Query::setId('REPORTED_FINANCIALS');
    }
}
