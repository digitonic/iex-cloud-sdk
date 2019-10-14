# API System Metadata

## Status

Used to retrieve current system status.

**Example**

```php
use \Digitonic\IexCloudSdk\APISystemMetadata\Status;

$endpoint = new Status($client);
$response = $endpoint->get();

// Laravel
use \Digitonic\IexCloudSdk\Facades\APISystemMetadata\Status;

$response = Status::get();
```

**Response**

```php
Collection {#275 ▼
  #items: array:3 [▼
    "status" => "up"
    "version" => "1.17"
    "time" => 1570900357804
  ]
}
```
