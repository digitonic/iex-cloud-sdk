<?php

namespace Digitonic\IexCloudSdk\Requests;

use Digitonic\IexCloudSdk\Contracts\IEXCloud;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Collection;

abstract class BaseGet
{
    const ENDPOINT = '';

    protected $method = 'GET';

    protected $api;

    /**
     * @var string
     */
    protected $symbol = '';

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
     * @param  string  $symbol
     *
     * @return BaseGet
     */
    public function setSymbol(string $symbol): self
    {
        $this->symbol = $symbol;

        return $this;
    }

    /**
     * @return Collection
     */
    public function send(): Collection
    {
        $this->validateParams();

        $request = new Request($this->method, $this->getFullEndpoint());

        $response = $this->api->send($request);

        return collect(json_decode($response->getBody()->getContents()));
    }

    abstract protected function getFullEndpoint(): string;

    /**
     * @return bool
     */
    protected function validateParams()
    {
        return true;
    }
}
