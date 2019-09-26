# Getting Started

```php
    $baseUrl = 'https://cloud.iexapis.com/v1/';
    $secretKey = 'xFiXd5RnPhUD8Qz1Q2esNVIFfqmrqgB';
```

```php
    // Instantiate a new Guzzle client
    $guzzle = new Client([
        'base_uri' => $baseUrl,
        'headers' => [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ],
        'query' => ['token' => $secretKey]
    ]);
```

```php
    // Instantiate a new IEX API client with the Guzzle dependency.
    $iexApi = new \Digitonic\IexCloudSdk\Client($guzzle);
```

The IEX API client can now be used as a dependency for communicating with various endpoints. for example, to call the `account/metadata` endpoint - 

```php
    $metadata = new \Digitonic\IexCloudSdk\Account\Metadata($iexApi);
    $response = $metadata->send();
    
    print_r($response);
```

All endpoints that return data will return data as a `\Illuminate\Support\Collection`. This will provide various utility methods when searching the response. For more information on Laravel Collections see [https://laravel.com/docs/6.x/collections](https://laravel.com/docs/6.x/collections). Please note, this package does not require the full Laravel framework to be used.

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

### Laravel >5.8 Usage

The package will auto register the service provider and all Facades.

You can publish the config file of this package with this command:

``` bash
php artisan vendor:publish --provider="Digitonic\IexCloudSdk\IexCloudSdkServiceProvider"
```

The following [config](config/config.php) file will be published in `config/iex-cloud-sdk.php`

Once you have installed the package, configure your `.env` with the following keys setting the correct values for your account.

```bash
    IEX_CLOUD_SANDBOX=true
    IEX_CLOUD_SECRET_KEY=Tsk_1234567899876543211236547896541c
    IEX_CLOUD_PUBLIC_KEY=Tpk_1234567899876543211236547896541c
```

#### IoC container

The IoC container will automatically resolve the `IEX API` dependencies for you when calling any endpoint. Which means you can just type hint your endpoint to retrieve the object from the container with all configurations in place.

```php
// From a constructor
class FooClass {
    public function __construct(Digitonic\IexCloudSdk\Account\Metadata $metadata) {
       $response = $metadata->send();
    }
}

// From a method
class BarClass {
    public function barMethod(Digitonic\IexCloudSdk\Account\Metadata $metadata) {
       $response = $metadata->send();
    }
}
```

Alternatively you may use the facades directly which provides a much faster and fluent interface.

```php
    $response = Digitonic\IexCloudSdk\Facades\Account\Metadata::send();
```
