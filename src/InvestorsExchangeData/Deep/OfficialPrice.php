<?php

namespace Digitonic\IexCloudSdk\InvestorsExchangeData\Deep;

use Digitonic\IexCloudSdk\Contracts\IEXCloud;
use Digitonic\IexCloudSdk\Exceptions\WrongData;
use Digitonic\IexCloudSdk\Requests\BaseRequest;

class OfficialPrice extends BaseRequest
{
    const ENDPOINT = 'deep/official-price?symbols={symbols}';

    /**
     * @var string
     */
    private $symbols;

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
     * @param  mixed  ...$symbols
     *
     * @return OfficialPrice
     */
    public function setSymbols(...$symbols): self
    {
        $this->symbols = implode(',', $symbols);

        return $this;
    }

    /**
     * @return string
     */
    protected function getFullEndpoint(): string
    {
        return str_replace('{symbols}', $this->symbols, self::ENDPOINT);
    }

    /**
     * @return bool|void
     */
    protected function validateParams(): void
    {
        if (empty($this->symbols)) {
            throw WrongData::invalidValuesProvided('Please provide symbol(s) to query!');
        }
    }
}
