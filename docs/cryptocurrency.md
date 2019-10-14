# Cryptocurrency

## Crypto Book

This returns a current snapshot of the book for a specified cryptocurrency.

**Example**

```php
use \Digitonic\IexCloudSdk\AlternativeData\Crypto\Book;

$endpoint = new Book($client);
$response = $endpoint->setSymbol('BTCUSDT')->get();

// Laravel
use \Digitonic\IexCloudSdk\Facades\AlternativeData\Crypto\Book;

$response = Book::setSymbol('BTCUSDT')->get();
```

**Response**

```php
Collection {#272 ▼
  #items: array:2 [▼
    "bids" => array:1 [▼
      0 => {#277 ▼
        +"price": "8400.34"
        +"size": "0.054989"
        +"timestamp": 1615268896297
      }
    ]
    "asks" => array:1 [▼
      0 => {#278 ▼
        +"price": "8479.93"
        +"size": "0.033894"
        +"timestamp": 1630724675505
      }
    ]
  ]
}
```

## Crypto Price

This returns the price for a specified cryptocurrency.

**Example**

```php
use \Digitonic\IexCloudSdk\AlternativeData\Crypto\Price;

$endpoint = new Price($client);
$response = $endpoint->setSymbol('BTCUSDT')->get();

// Laravel
use \Digitonic\IexCloudSdk\Facades\AlternativeData\Crypto\Price;

$response = Price::setSymbol('BTCUSDT')->get();
```

**Response**

```php
Collection {#275 ▼
  #items: array:2 [▼
    "price" => "8598.47"
    "symbol" => "BTCUSDT"
  ]
}
```

## Crypto Quote

This returns the quote for a specified cryptocurrency.

**Example**

```php
use \Digitonic\IexCloudSdk\AlternativeData\Crypto\Quote;

$endpoint = new Quote($client);
$response = $endpoint->setSymbol('BTCUSDT')->get();

// Laravel
use \Digitonic\IexCloudSdk\Facades\AlternativeData\Crypto\Quote;

$response = Quote::setSymbol('BTCUSDT')->get();
```

**Response**

```php
Collection {#275 ▼
  #items: array:15 [▼
    "symbol" => "BTCUSDT"
    "primaryExchange" => "0"
    "sector" => "nrcpercyuytrco"
    "calculationPrice" => "realtime"
    "latestPrice" => "8498.33"
    "latestSource" => "Real time price"
    "latestUpdate" => 1597241012754
    "latestVolume" => null
    "bidPrice" => "8438.55"
    "bidSize" => "0.026231"
    "askPrice" => "8357"
    "askSize" => "0.237439"
    "high" => null
    "low" => null
    "previousClose" => null
  ]
}
```
