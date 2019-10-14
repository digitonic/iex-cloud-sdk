<?php

namespace Digitonic\IexCloudSdk\Stocks;

use Digitonic\IexCloudSdk\Contracts\IEXCloud;
use Digitonic\IexCloudSdk\Exceptions\WrongData;
use Digitonic\IexCloudSdk\Requests\BaseRequest;

class News extends BaseRequest
{
    const ENDPOINT = 'stock/{symbol}/news{last}';

    /**
     * @var int
     */
    private $last;

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
     * @param  int  $take
     *
     * @return $this
     * @throws WrongData
     */
    public function take(int $take): self
    {
        $this->validateLastParam($take);

        $this->last = $take;

        return $this;
    }

    /**
     * @return string
     */
    protected function getFullEndpoint(): string
    {
        $endpoint = str_replace('{symbol}', $this->symbol, self::ENDPOINT);
        $endpoint = str_replace('{last}', "/last/$this->last", $endpoint);

        return $endpoint;
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
     * @param  int  $take
     *
     * @throws WrongData
     */
    private function validateLastParam(int $take)
    {
        if ($take < 1) {
            throw WrongData::invalidValuesProvided('Must take at least one item.');
        }

        if ($take > 50) {
            throw WrongData::invalidValuesProvided('Cannot take more than 50 items in one call');
        }
    }
}
