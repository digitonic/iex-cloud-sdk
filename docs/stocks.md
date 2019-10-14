# Stocks

## Advanced Stats

**Example**

```php
use \Digitonic\IexCloudSdk\Stocks\AdvancedStats;

$endpoint = new AdvancedStats($client);
$response = $endpoint->setSymbol('aapl')->get();

// Laravel
use \Digitonic\IexCloudSdk\Facades\Stocks\AdvancedStats;

$response = AdvancedStats::setSymbol('aapl')->get();
```

**Response**

```php
Collection {#275 ▼
  #items: array:48 [▼
    "week52change" => 0.075238
    "week52high" => 239.76
    "week52low" => 149
    "marketcap" => 1053163233867
    "employees" => 136690
    "day200MovingAvg" => 198.57
    "day50MovingAvg" => 215.01
    "float" => 4614803231.65
    "avg10Volume" => 30745371.8
    "avg30Volume" => 29058999.5
    "ttmEPS" => 12.35
    "ttmDividendRate" => 3.02
    "companyName" => "Apple, Inc."
    "sharesOutstanding" => 4631122772
    "maxChangePercent" => 237.1558
    "year5ChangePercent" => 1.3461
    "year2ChangePercent" => 0.496
    "year1ChangePercent" => 0.074545
    "ytdChangePercent" => 0.461451
    "month6ChangePercent" => 0.15767
    "month3ChangePercent" => 0.144236
    "month1ChangePercent" => 0.029289
    "day30ChangePercent" => 0.103451
    "day5ChangePercent" => 0.013725
    "nextDividendDate" => null
    "dividendYield" => 0.013236628206334
    "nextEarningsDate" => "2019-10-30"
    "exDividendDate" => "2019-08-21"
    "peRatio" => 20.21
    "beta" => 1.562248155631
    "totalCash" => 68907243651
    "currentDebt" => 20955390131
    "revenue" => 274040365476
    "grossProfit" => 106997648374
    "totalRevenue" => 270458247991
    "EBITDA" => 84232077562
    "revenuePerShare" => 59.51
    "revenuePerEmployee" => 2023261.99
    "debtToEquity" => 1.12
    "profitMargin" => 0.2263578794686
    "enterpriseValue" => 1123390829444
    "enterpriseValueToRevenue" => 4.28
    "priceToSales" => 4
    "priceToBook" => 10.12045889477
    "forwardPERatio" => 20.4
    "pegRatio" => -2.91
    "peHigh" => 20.19903852975
    "peLow" => 12.572083819829
  ]
}
```

## Balance Sheet

!> Still to be documented

## Batch Requests

!> Still to be documented

## Company

**Example**

```php
use \Digitonic\IexCloudSdk\Stocks\Company;

$endpoint = new Company($client);
$response = $endpoint->setSymbol('aapl')->get();

// Laravel
use \Digitonic\IexCloudSdk\Facades\Stocks\Company;

$response = Company::setSymbol('aapl')->get();
```

**Response**

```php
Collection {#275 ▼
  #items: array:20 [▼
    "symbol" => "AAPL"
    "companyName" => "Apple, Inc."
    "exchange" => "ADQNSA"
    "industry" => "eqempesmincmlaEToctutnouni i"
    "website" => "h./cmopwtwpt.lw/epa:"
    "description" => "do rpa apimkaz giieC rlCg  nhlopgaeqV,s ahha, ,fn dsT,lTA)e es uw rf  Coam  T olsaetS a sgWoA.ai ev,g, rhaletasteri n iocsl,aep si hdGa fEtetdIu,, n  tinIngnm d ▶"
    "CEO" => "nhoya omTdCo oilDtk"
    "securityName" => "cpA.l pneI"
    "issueType" => "sc"
    "sector" => "icgoeoctllrnncehEoT y"
    "primarySicCode" => 3745
    "employees" => 136025
    "tags" => array:2 [▶]
    "address" => "n akrplApPWye Oe a"
    "address2" => null
    "state" => "AC"
    "city" => "tupeCiorn"
    "zip" => "1320984-50"
    "country" => "SU"
    "phone" => "4821.10933.4.7"
  ]
}
```

## Logo

This is a helper function, but the Google APIs url is standardized.

**Example**

```php
use \Digitonic\IexCloudSdk\Stocks\Logo;

$endpoint = new Logo($client);
$response = $endpoint->setSymbol('aapl')->get();

// Laravel
use \Digitonic\IexCloudSdk\Facades\Stocks\Logo;

$response = Logo::setSymbol('aapl')->get();
```

**Response**

```php
Collection {#275 ▼
  #items: array:1 [▼
    "url" => "https://storage.googleapis.com/iex/api/logos/AAPL.png"
  ]
}
```

## News

**Example**

```php
use \Digitonic\IexCloudSdk\Stocks\News;

$endpoint = new News($client);
$response = $endpoint->setSymbol('aapl')->get();

// Laravel
use \Digitonic\IexCloudSdk\Facades\Stocks\News;

$response = News::setSymbol('aapl')->get();

// Limit results (between 1 and 50) - default 10
$response = News::setSymbol('aapl')->take(5)->get();
```

**Response**

```php
Collection {#281 ▼
  #items: array:10 [▼
    0 => {#277 ▼
      +"datetime": 1585798516729
      +"headline": "iu  McDcxsl ovo kSiosfefllTol ielESdap rs onptotp Aelo"
      +"source": "orBs'arn"
      +"url": "o-3sp9d2ee/tfa1./pl2cnc--6xti8r2eo0044wdthl5:f485m0-4s/e4ivaued602./s/cc/7icc2"
      +"summary": "r yphef-rk s   u ki driodoaapiardencselaeshfw ffcpor  ehnha loaifeelhaadtf  ns5ntaie ctoegfrcithocctcasi gArte enni eddihino2nhastigcnpnt. aT  "
      +"related": "APLA"
      +"image": "7/06pes.4h.fisnem-2//x0w8/-pae093-c2-:i5at5o6/e4s41vte224m0lodcc2ifuc8/c4dgd"
      +"lang": "ne"
      +"hasPaywall": true
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
  ]
}
```

## Price

**Example**

```php
use \Digitonic\IexCloudSdk\Stocks\Price;

$endpoint = new Price($client);
$response = $endpoint->setSymbol('aapl')->get();

// Laravel
use \Digitonic\IexCloudSdk\Facades\Stocks\Price;

$response = Price::setSymbol('aapl')->get();
```

**Response**

```php
Collection {#277 ▼
  #items: array:1 [▼
    0 => 244.25
  ]
}
```
