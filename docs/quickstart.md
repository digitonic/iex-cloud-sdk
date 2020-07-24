# Quick Start

Although the SDK can be used in a standalone application with composer, it works best when it is included with a Laravel application.

## Installation

You can install the package via composer:

```bash
composer require nk19/iex-cloud-sdk
```

## Basic Usage 

Obtain your secret and public keys from the IEX Console. The base URL can be swapped out for the sandbox URL and paired with sandbox keys will allow your to work in development mode.
```php
$baseUrl = 'https://cloud.iexapis.com/v1/';
$secretKey = 'sFiXd5RnPhUD8Qz1Q2esNVIFfqmrqgB';
$publicKey = 'pFiXd5RnPhUD8Qz1Q2esNVIFfqmrqgB';
```

The SDK uses Guzzle as dependency for interacting with the HTTP layer. You should instantiate a new Guzzle client with your `$baseUrl` and `$secretKey` as shown below.

```php
$guzzle = new Client([
    'base_uri' => $baseUrl,
    'headers' => [
        'Accept' => 'application/json',
        'Content-Type' => 'application/json'
    ],
    'query' => ['token' => $secretKey]
]);
```

You can now use the Guzzle client as a dependency for the IEX SDK client. The IEX Client is nothing more than a simple configuration wrapper for the Guzzle client that exposes one method `send()`, this `send` method is public which means you are free to override this or call it directly should you wish. The send method will be used for all endpoints exposed in the SDK and will catch and display any and all data related errors. 

```php
$client = new \Digitonic\IexCloudSdk\Client($guzzle);
```

The IEX API client can now be used as a dependency for communicating with various endpoints. for example, to call the `account/metadata` endpoint - 

```php
use \Digitonic\IexCloudSdk\Account\Metadata;

$metadata = new Metadata($client);
$response = $metadata->get();

print_r($response);
```

All endpoints that return data will return data as a `\Illuminate\Support\Collection`. This will provide various utility methods when searching the response. For more information on Laravel Collections see [https://laravel.com/docs/6.x/collections](https://laravel.com/docs/6.x/collections).

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

## Laravel Usage

The SDK comes with a Laravel Service Provider to facilitate a much cleaner and streamlined setup. The SDK will only work with Laravel 5.8 and above and as such the package will automatically register the provider and the facades.

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

The IoC container will automatically resolve the `IEX API Client` dependencies for you when calling any endpoint. Which means you can just type hint your endpoint to retrieve the object from the container with all configurations in place.

```php
use \Digitonic\IexCloudSdk\Account\Metadata;

// From a constructor
class FooClass {
    public function __construct(Metadata $metadata) {
       $response = $metadata->get();
    }
}

// From a method
class BarClass {
    public function barMethod(Metadata $metadata) {
       $response = $metadata->get();
    }
}
```

Alternatively you may use the facades directly which provides a much faster and fluent interface.

```php
use \Digitonic\IexCloudSdk\Facades\Account\Metadata;

$response = Metadata::get();
```

Some endpoints require extra parameters being passed to the endpoint object. Please see each endpoint documentation for requirements and example usage.
