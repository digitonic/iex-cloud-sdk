<?php

namespace Digitonic\IexCloudSdk\Stocks;

use Digitonic\IexCloudSdk\Contracts\IEXCloud;
use Digitonic\IexCloudSdk\Exceptions\WrongData;
use Digitonic\IexCloudSdk\Requests\BaseRequest;

class DelayedQuote extends BaseRequest
{
    const ENDPOINT = 'stock/{symbol}/delayed-quote';

    /**
     * @var bool
     */
    protected $oddLot = false;

    /**
     * Create constructor.
     *
     * @param  IEXCloud  $api
     */
    public function __construct(IEXCloud $api)
    {
        parent::__construct($api);
    }

    /**
     * If the oddLot property is set, add it to the end of the endpoint string.
     *
     * @return string
     */
    protected function getFullEndpoint(): string
    {
        $endpoint = str_replace('{symbol}', $this->symbol, self::ENDPOINT);

        return $this->oddLot ? "$endpoint/oddLot=$this->oddLot" : $endpoint;
    }

    /**
     * @return bool|void
     * @throws WrongData
     */
    protected function validateParams(): void
    {
        if (empty($this->symbol)) {
            throw WrongData::invalidValuesProvided('Please provide a symbol to query!');
        }
    }

    public function oddLot(bool $oddLot = true): self
    {
        $this->oddLot = $oddLot;

        return $this;
    }
}
