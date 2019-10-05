<?php

namespace Digitonic\IexCloudSdk\ReferenceData;

use Digitonic\IexCloudSdk\Contracts\IEXCloud;
use Digitonic\IexCloudSdk\Exceptions\WrongData;
use Digitonic\IexCloudSdk\Requests\BaseRequest;

class ExchangeSymbols extends BaseRequest
{
    const ENDPOINT = 'ref-data/exchange/{exchange}/symbols';

    /**
     * @var string
     */
    private $exchange;

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
     * @param  string  $exchange
     *
     * @return ExchangeSymbols
     */
    public function setExchange(string $exchange): self
    {
        $this->exchange = $exchange;

        return $this;
    }

    /**
     * @return string
     */
    protected function getFullEndpoint(): string
    {
        return str_replace('{exchange}', $this->exchange, self::ENDPOINT);
    }

    /**
     * @return bool|void
     */
    protected function validateParams(): void
    {
        if (empty($this->exchange)) {
            throw WrongData::invalidValuesProvided(
                'Required case insensitive string of Exchange using IEX Supported Exchanges list'
            );
        }
    }
}
