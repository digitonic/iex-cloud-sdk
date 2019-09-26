<?php

namespace Digitonic\IexCloudSdk\Tests\Unit;

use Digitonic\IexCloudSdk\Contracts\IEXCloud;
use Digitonic\IexCloudSdk\Exceptions\InvalidConfig;
use Digitonic\IexCloudSdk\Facades\Account\Metadata;
use Digitonic\IexCloudSdk\Facades\Account\Usage;
use Digitonic\IexCloudSdk\Tests\BaseTestCase;

class ConfigTest extends BaseTestCase
{
    /** @test */
    public function it_will_throw_error_if_base_url_not_set()
    {
        $this->app['config']->set('iex-cloud-sdk.base_url', '');

        $this->expectException(InvalidConfig::class);

        Metadata::send();
    }

    /** @test */
    public function it_will_throw_error_if_secret_key_not_set()
    {
        $this->app['config']->set('iex-cloud-sdk.secret_key', '');

        $this->expectException(InvalidConfig::class);

        Usage::send();
    }

    /** @test */
    public function it_will_throw_error_if_public_key_not_set()
    {
        $this->app['config']->set('iex-cloud-sdk.secret_key', 'KxDMt9GNVgu6fJUOG0UjH3d4kjZPTxFiXd5RnPhUD8Qz1Q2esNVIFfqmrqRD');
        $this->app['config']->set('iex-cloud-sdk.public_key', '');

        $this->expectException(InvalidConfig::class);

        Metadata::send();
    }

    /** @test */
    public function it_should_return_api_client_from_container()
    {
        $this->app['config']->set('iex-cloud-sdk.base_url', 'https://cloud.iexapis.com/v1/');
        $this->app['config']->set('iex-cloud-sdk.secret_key', 'KxDMt9GNVgu6fJUOG0UjH3d4kjZPTxFiXd5RnPhUD8Qz1Q2esNVIFfqmrqRD');
        $this->app['config']->set('iex-cloud-sdk.public_key', 'KxDMt9GNVgu6fJUOG0UjH3d4kjZPTxFiXd5RnPhUD8Qz1Q2esNVIFfqmrqRD');

        $iexApi = app(IEXCloud::class);

        $this->assertInstanceOf(IEXCloud::class, $iexApi);
    }
}
