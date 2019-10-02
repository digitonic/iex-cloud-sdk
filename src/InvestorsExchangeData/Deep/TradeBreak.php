<?php

namespace Digitonic\IexCloudSdk\InvestorsExchangeData\Deep;

use Digitonic\IexCloudSdk\Contracts\IEXCloud;
use Digitonic\IexCloudSdk\Exceptions\WrongData;
use Digitonic\IexCloudSdk\InvestorsExchangeData\Last;
use Digitonic\IexCloudSdk\Requests\BaseGet;

class TradeBreak extends BaseGet
{
    const ENDPOINT = 'deep/trade-breaks?symbols={symbols}&last={last}';

    /**
     * @var string
     */
    private $symbols;

    /**
     * @var int
     */
    private $last = 20;

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
     * @return TradeBreak
     */
    public function setSymbols(...$symbols): self
    {
        $this->symbols = implode(',', $symbols);

        return $this;
    }

    /**
     * @param  int  $last
     *
     * @return TradeBreak
     */
    public function setLast(int $last): self
    {
        $this->validateLast($last);

        $this->last = $last;

        return $this;
    }

    /**
     * @return string
     */
    protected function getFullEndpoint(): string
    {
        $endpoint = str_replace('{symbols}', $this->symbols, self::ENDPOINT);
        $endpoint = str_replace('{last}', $this->last, $endpoint);

        return $endpoint;
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

    private function validateLast(int $last)
    {
        if ($last > 500) {
            throw WrongData::invalidValuesProvided('Last query param must be less than 500');
        }
    }
}
