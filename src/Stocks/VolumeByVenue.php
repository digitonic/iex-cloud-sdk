<?php

namespace Digitonic\IexCloudSdk\Stocks;

use Digitonic\IexCloudSdk\Contracts\IEXCloud;
use Digitonic\IexCloudSdk\Exceptions\WrongData;
use Digitonic\IexCloudSdk\Requests\BaseRequest;

class VolumeByVenue extends BaseRequest
{
    const ENDPOINT = 'stock/{symbol}/volume-by-venue';

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
     * If the field property is set, add it to the end of the endpoint string.
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
