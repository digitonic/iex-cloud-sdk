<?php

namespace Digitonic\IexCloudSdk\Stocks;

use Digitonic\IexCloudSdk\Contracts\IEXCloud;
use Digitonic\IexCloudSdk\Exceptions\WrongData;
use Digitonic\IexCloudSdk\Requests\BaseRequest;

/**
 * Class IntradayPrices
 * @package Digitonic\IexCloudSdk\Stocks
 * todo - Currently there is no mechanism for optional fields to be passed.
 */
class IntradayPrices extends BaseRequest
{
    const ENDPOINT = 'stock/{symbol}/intraday-prices';

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
        return str_replace('{symbol}', $this->symbol, self::ENDPOINT);
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
}
