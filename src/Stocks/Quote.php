<?php

namespace Digitonic\IexCloudSdk\Stocks;

use Digitonic\IexCloudSdk\Contracts\IEXCloud;
use Digitonic\IexCloudSdk\Exceptions\WrongData;
use Digitonic\IexCloudSdk\Requests\BaseRequest;

class Quote extends BaseRequest
{
    const ENDPOINT = 'stock/{symbol}/quote';

    /**
     * IEX Cloud Documentation provides for the optional field to be added to
     * the end of the endpoint uri in order to retrieve a specific field.
     * This property allows that functionality to be used in this SDK.
     */
    public $field;

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
        $endpoint = str_replace('{symbol}', $this->symbol, self::ENDPOINT);

        return $this->field ? "$endpoint/$this->field" : $endpoint;
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

    /**
     * Setter for field property
     *
     * @param  string  $field
     *
     * @return Quote
     */
    public function only(string $field): self
    {
        $this->field = $field;

        return $this;
    }
}
