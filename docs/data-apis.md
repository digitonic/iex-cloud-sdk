# Data APIs

## Data Points

Data points are available per symbol and return individual plain text values. Retrieving individual data points is useful for Excel and Google Sheet users, and applications where a single, lightweight value is needed.

To use this endpoint, you’ll first make a free call to list all available data points for your desired symbol, which can be a security or data category.

**Example**

```php
use \Digitonic\IexCloudSdk\DataApis\DataPoints;

$endpoint = new DataPoints($client);
$response = $endpoint->setSymbol('aapl')->get();

// Laravel
use \Digitonic\IexCloudSdk\Facades\DataApis\DataPoints;

$response = DataPoints::setSymbol('aapl')->get();
```

**Response**

```php
Collection {#397 ▼
  #items: array:126 [▼
    0 => {#277 ▼
      +"key": "NEXTDIVIDENDDATE"
      +"weight": 1
      +"description": ""
      +"lastUpdated": "2019-08-09T08:50:31+00:00"
    }
    1 => {#275 ▶}
    2 => {#278 ▶}
    3 => {#272 ▶}
    4 => {#267 ▶}
    5 => {#265 ▶}
...
```
Once you find the data point you want, use the key to fetch the individual data point.

**Example**

```php
use \Digitonic\IexCloudSdk\DataApis\DataPoints;

$endpoint = new DataPoints($client);
$response = $endpoint->setSymbol('aapl')
                 ->setKey('NEXTDIVIDENDDATE')
                 ->get();

// Laravel
use \Digitonic\IexCloudSdk\Facades\DataApis\DataPoints;

$response = DataPoints::setSymbol('aapl')
                ->setKey('NEXTDIVIDENDDATE')
                ->get();
```

**Response**

```php
Collection {#277 ▼
  #items: array:1 [▼
    0 => "2019-08-20"
  ]
}
```

## Time Series Inventory

Time series is the most common type of data available, and consists of a collection of data points over a period of time. Time series data is indexed by a single date field, and can be retrieved by any portion of time.

To use this endpoint, you’ll first make a free call to get an inventory of available time series data.

**Example**

```php
use \Digitonic\IexCloudSdk\DataApis\TimeSeries\Inventory;

$endpoint = new Inventory($client);
$response = $endpoint->get();

// Laravel
use \Digitonic\IexCloudSdk\Facades\DataApis\TimeSeries\Inventory;

$response = Inventory::get();
```

**Response**

```php
Collection {#281 ▼
  #items: array:1 [▼
    0 => {#277 ▼
      +"id": "ERAATLIF_OSPRNDCNIE"
      +"description": "edas tfaRpieonlcnri"
      +"schema": {#275 ▼
        +"type": "object"
        +"properties": {#272 ▼
          +"formFiscalYear": {#278 ▼
            +"type": "number"
          }
          +"formFiscalQuarter": {#267 ▼
            +"type": "number"
          }
          +"version": {#265 ▼
            +"type": "string"
          }
          +"periodStart": {#276 ▼
            +"type": "string"
          }
          +"periodEnd": {#269 ▼
            +"type": "string"
          }
          +"dateFiled": {#279 ▼
            +"type": "string"
          }
          +"reportLink": {#280 ▼
            +"type": "string"
          }
        }
        +"required": []
        +"additionalProperties": true
      }
      +"weight": 5080
      +"created": "32240- 001-:13604:9"
      +"lastUpdated": "12400- :00-6349:213"
    }
  ]
}
```
A full inventory of time series data is returned by calling /time-series without a data id. The data structure returned is an array of available data sets that includes the data set id, a description of the data set, the data weight, a data schema, date created, and last updated date. The schema defines the minimum data properties for the data set, but note that additional properties can be returned. This is possible when data varies between keys of a given data set.

Each inventory entry may include a key and subkey which describes what can be used for the key or subkey parameter.

## Time Series Query

Once you find the data set you want, use the id to query the time series data.

Time series data is queried by a required data set id. For example, “REPORTED_FINANCIALS”. Some time series data sets are broken down further by a data set key. This may commonly be a symbol. For example, REPORTED_FINANCIALS accepts a symbol such as “AAPL” as a key. Data sets can be even further broken down by sub key. For example, REPORTED_FINANCIALS data set with the key “AAPL” can have a sub key of “10-Q” or “10-K”.

Keys and sub keys will be defined in the data set inventory.

**Example**

```php
use \Digitonic\IexCloudSdk\DataApis\TimeSeries\Query;

$endpoint = new Inventory($client);
$response = $endpoint->get();

// Laravel
use \Digitonic\IexCloudSdk\Facades\DataApis\TimeSeries\Query;

$response = Query::setId('REPORTED_FINANCIALS')
                ->setKey('AAPL')
                ->setSubKey('10-Q')
                ->get();
```

!> Query String Parameters still to be implemented

**Response**

```php
Collection {#301 ▼
  #items: array:30 [▼
    0 => {#277 ▼
      +"id": "EECINTS_RALDFOAIRPN"
      +"source": "SEC"
      +"key": "ALPA"
      +"subkey": "01Q-"
      +"updated": 1609211733
      +"AccountsPayable": 4921590385
      +"formFiscalYear": 2087
      +"version": "sgaa-up"
      +"periodStart": 1273268848459
      +"periodEnd": 1272111501454
      +"dateFiled": 1304048033673
      +"formFiscalQuarter": 3
      +"reportLink": "0001w/vecA03da5ws53ss/pv9e3hgri/tw/315/0ec1/.1r.d090h:2a91tg0/261t0/oa"
      +"AccountsReceivableNetCurrent": 2738746127
      +"AccruedLiabilities": 3481227682
      +"AccumulatedOtherComprehensiveIncomeLossNetOfTax": 53392828
      +"AllowanceForDoubtfulAccountsReceivableCurrent": 58043568
      +"Assets": 49200608778
      +"AssetsCurrent": 36411768693
      +"AvailableForSaleSecuritiesCurrent": 18846832822
      +"AvailableForSaleSecuritiesNoncurrent": 7134630236
      +"CashAndCashEquivalentsAtCarryingValue": 5805755013
      +"CashAndCashEquivalentsPeriodIncreaseDecrease": -6433032533
      +"CommitmentsAndContingencies": 0
      +"CommonStockNoParValue": 0
      +"CommonStockSharesAuthorized": 1818958014
      +"CommonStockSharesIssued": 896700592
      +"CommonStockSharesOutstanding": 916218997
      +"CommonStockValue": 8073436587
      +"CostOfGoodsAndServicesSold": 17467639130
      +"DeferredIncomeTaxExpenseBenefit": -202044184
      +"DeferredRevenueCurrent": 8651845268
      +"DeferredRevenueNoncurrent": 3719260915
      +"DeferredTaxAssetsNetCurrent": 1736495003
      +"DepreciationAmortizationAndAccretionNet": 530942016
      +"EarningsPerShareBasic": 4.66
      +"EarningsPerShareDiluted": 4.58
      +"EmployeeServiceShareBasedCompensationCashFlowEffectCashUsedToSettleAwards": -71310080
      +"EntityCommonStockSharesOutstanding": 918060910
      +"EntityPublicFloat": 95831542710
      +"ExcessTaxBenefitFromShareBasedCompensationFinancingActivities": 128369811
      +"GainLossOnSaleOfPropertyPlantEquipment": -18362101
      +"Goodwill": 217003955
      +"GrossProfit": 3132775287
      +"IncomeLossFromContinuingOperationsBeforeIncomeTaxesMinorityInterestAndIncomeLossFromEquityMethodInvestments": 5906177733
      +"IncomeTaxesPaidNet": 2537284672
      +"IncomeTaxExpenseBenefit": 1765366397
      +"IncreaseDecreaseInAccountsPayable": -662362318
      +"IncreaseDecreaseInAccountsReceivable": 274659341
      +"IncreaseDecreaseInDeferredRevenue": 4279857195
      +"IncreaseDecreaseInInventories": -132276691
      +"IncreaseDecreaseInOtherOperatingAssets": 821126708
      +"IncreaseDecreaseInOtherOperatingLiabilities": -208539076
      +"IncreaseDecreaseOtherCurrentAssets": 301712345
      +"IntangibleAssetsNetExcludingGoodwill": 271072839
      +"InventoryNet": 380357258
      +"Liabilities": 23222565863
      +"LiabilitiesAndStockholdersEquity": 48356475067
      +"LiabilitiesCurrent": 17143774626
      +"NetCashProvidedByUsedInFinancingActivities": 360762189
      +"NetCashProvidedByUsedInInvestingActivities": -13755834742
      +"NetCashProvidedByUsedInOperatingActivities": 7319639761
      +"NetIncomeLoss": 1254413101
      +"NonoperatingIncomeExpense": 286707314
      +"OperatingExpenses": 1364587805
      +"OperatingIncomeLoss": 5654982022
      +"OtherAssetsCurrent": 6199701923
      +"OtherAssetsNoncurrent": 3052719603
      +"OtherLiabilitiesNoncurrent": 1974929483
      +"PaymentsForProceedsFromOtherInvestingActivities": 63505109
      +"PaymentsToAcquireAvailableForSaleSecurities": 35742646912
      +"PaymentsToAcquireIntangibleAssets": 56884699
      +"PaymentsToAcquireOtherInvestments": 62223140
      +"PaymentsToAcquireProductiveAssets": 713483118
      +"ProceedsFromIssuanceOfCommonStock": 299593198
      +"ProceedsFromMaturitiesPrepaymentsAndCallsOfAvailableForSaleSecurities": 12840799027
      +"ProceedsFromSaleOfAvailableForSaleSecurities": 9217869605
      +"PropertyPlantAndEquipmentAndCapitalizedSoftwareNet": 2766515102
      +"ResearchAndDevelopmentExpense": 346967174
      +"RetainedEarningsAccumulatedDeficit": 18471282567
      +"SalesRevenueNet": 8423777984
      +"SellingGeneralAndAdministrativeExpense": 1051686313
      +"ShareBasedCompensation": 554779236
      +"StockholdersEquity": 26621258478
      +"WeightedAverageNumberOfDilutedSharesOutstanding": 942565128
      +"WeightedAverageNumberOfSharesOutstandingBasic": 922346050
    }
    1 => {#275 ▶}
    2 => {#278 ▶}
    3 => {#272 ▶}
    4 => {#267 ▶}
    5 => {#265 ▶}
    6 => {#276 ▶}
    7 => {#269 ▶}
    8 => {#279 ▶}
    9 => {#280 ▶}
    10 => {#281 ▶}
    11 => {#282 ▶}
    12 => {#283 ▶}
    13 => {#284 ▶}
    14 => {#285 ▶}
    15 => {#286 ▶}
    16 => {#287 ▶}
    17 => {#288 ▶}
    18 => {#289 ▶}
    19 => {#290 …99}
    20 => {#291 …114}
    21 => {#292 …151}
    22 => {#293 …127}
    23 => {#294 …103}
    24 => {#295 …104}
    25 => {#296 …125}
    26 => {#297 …137}
    27 => {#298 …154}
    28 => {#299 …149}
    29 => {#300 …102}
  ]
}
```

Read more at [IEX API Docs](https://iexcloud.io/docs/api/#time-series)
