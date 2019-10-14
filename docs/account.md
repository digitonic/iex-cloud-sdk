# Account

## Metadata

Used to retrieve account details such as current tier, payment status, message quote usage, etc.

**Example**

```php
use \Digitonic\IexCloudSdk\Account\Metadata;

$endpoint = new Metadata($client);
$response = $endpoint->get();

// Laravel
use \Digitonic\IexCloudSdk\Facades\Account\Metadata;

$response = Metadata::get();
```

**Response**

```php
Collection {#275 ▼
  #items: array:7 [▼
    "payAsYouGoEnabled" => false
    "effectiveDate" => 1621337109805
    "subscriptionTermType" => "mnlhyto"
    "tierName" => "tstar"
    "messageLimit" => 514440
    "messagesUsed" => 13578
    "circuitBreaker" => null
  ]
}
```

## Usage

Used to retrieve current month usage for your account.

**Example**

```php
use \Digitonic\IexCloudSdk\Account\Usage;

$endpoint = new Usage($client);
$response = $endpoint->get();

// Laravel
use \Digitonic\IexCloudSdk\Facades\Account\Usage;

$response = Usage::get();
```

**Response**

```php
Collection {#265 ▼
  #items: array:2 [▼
    "messages" => {#275 ▼
      +"dailyUsage": {#277 ▶}
      +"monthlyUsage": 12778
      +"monthlyPayAsYouGo": 0
      +"tokenUsage": {#278 ▶}
      +"keyUsage": {#272 ▶}
    }
    "rules" => []
  ]
}
```
