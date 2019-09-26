<?php

namespace Digitonic\IexCloudSdk\Requests;

use Digitonic\IexCloudSdk\Contracts\IEXCloud;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Collection;

class BaseGet
{
    const ENDPOINT = '';

    protected $method = 'GET';

    protected $api;

    /**
     * Create constructor.
     *
     * @param  IEXCloud  $api
     */
    public function __construct(IEXCloud $api)
    {
        $this->api = $api;
    }

    /**
     * @return Collection
     */
    public function send(): Collection
    {
        $request = new Request($this->method, $this->getFullEndpoint());

        $response = $this->api->send($request);

        return collect(json_decode($response->getBody()->getContents()));
    }

    /**
     * @return string
     */
    protected function getFullEndpoint(): string
    {
        return self::ENDPOINT;
    }
}
