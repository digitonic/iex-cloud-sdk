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
