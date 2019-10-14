# Alternative Data

## Social Sentiment

This endpoint provides social sentiment data from StockTwits. Data can be viewed as a daily value, or by minute for a given date.

```php
use \Digitonic\IexCloudSdk\AlternativeData\SocialSentiment;

$endpoint = new SocialSentiment($client);
$response = $endpoint->setSymbol('aapl')
                ->setDate('20191012') // optional
                ->setType('minute') // optional
                ->get();

// Laravel
use \Digitonic\IexCloudSdk\Facades\AlternativeData\SocialSentiment;

$response = SocialSentiment::setSymbol('aapl')
                ->setDate('20191012') // optional
                ->setType('minute') // optional
                ->get();
```

**Response**

```php
// Default daily 
Collection {#275 ▼
  #items: array:4 [▼
    "sentiment" => -0.03563327966
    "totalScores" => 133
    "positive" => 0.77
    "negative" => 0.26
  ]
}

// Minute
Collection {#390 ▼
  #items: array:119 [▼
    0 => {#277 ▼
      +"sentiment": 0
      +"totalScores": 1
      +"positive": 1
      +"negative": 0
      +"minute": "0006"
    }
    1 => {#275 ▼
      +"sentiment": 0.5764
      +"totalScores": 1
      +"positive": 1
      +"negative": 0
      +"minute": "0009"
    }
    2 => {#278 ▼
      +"sentiment": 0
      +"totalScores": 1
      +"positive": 1
      +"negative": 0
      +"minute": "0011"
    }
    3 => {#272 ▶}
...
```



## CEO Compensation

This endpoint provides CEO compensation for a company by symbol.

**Example**

```php
use \Digitonic\IexCloudSdk\AlternativeData\CeoComp;

$endpoint = new CeoComp($client);
$response = $endpoint->setSymbol('aapl')->get();

// Laravel
use \Digitonic\IexCloudSdk\Facades\AlternativeData\CeoComp;

$response = CeoComp::setSymbol('aapl')->get();
```

**Response**

```php
Collection {#275 ▼
  #items: array:13 [▼
    "symbol" => "AAPL"
    "name" => "oykh CtmooiT"
    "companyName" => "Apple Inc."
    "location" => "pCu,nACrt oei"
    "salary" => 3027049
    "bonus" => 0
    "stockAwards" => 0
    "optionAwards" => 0
    "nonEquityIncentives" => 12413724
    "pensionAndDeferred" => 0
    "otherComp" => 687647
    "total" => 16079556
    "year" => "2047"
  ]
}
```
