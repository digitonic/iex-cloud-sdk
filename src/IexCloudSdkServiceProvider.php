<?php

namespace Digitonic\IexCloudSdk;

use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;
use Digitonic\IexCloudSdk\Contracts\IEXCloud;
use Digitonic\IexCloudSdk\Exceptions\InvalidConfig;

class IexCloudSdkServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('iex-cloud-sdk.php'),
            ], 'config');
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'iex-cloud-sdk');

        $this->app->bind(IEXCloud::class, function () {
            $config = config('iex-cloud-sdk');

            $this->guardAgainstInvalidConfig($config);

            $guzzle = new Client([
                'base_uri' => $config['sandbox'] ? $config['sandbox_base_url'] : $config['base_url'],
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json'
                ],
                'query' => ['token' => $config['secret_key']]
            ]);

            return new \Digitonic\IexCloudSdk\Client($guzzle);
        });
    }

    /**
     * @param  array|null  $config
     */
    protected function guardAgainstInvalidConfig(array $config = null)
    {
        if (empty($config['base_url'])) {
            throw InvalidConfig::baseUrlNotSpecified();
        }

        if (empty($config['secret_key'])) {
            throw InvalidConfig::apiKeyNotSpecified();
        }

        if (empty($config['public_key'])) {
            throw InvalidConfig::apiKeyNotSpecified();
        }
    }
}
