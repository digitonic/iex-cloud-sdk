<?php

namespace Digitonic\IexCloudSdk\ForexCurrencies;

use Digitonic\IexCloudSdk\Contracts\IEXCloud;
use Digitonic\IexCloudSdk\Requests\BaseGet;

class ExchangeRates extends BaseGet
{
    const ENDPOINT = 'fx/rate/{from}/{to}';

    /**
     * @var string
     */
    private $fromCurrency = 'USD';

    /**
     * @var string
     */
    private $toCurrency = 'GBP';

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
     * @param  string  $fromCurrency
     *
     * @return ExchangeRates
     */
    public function setFrom(string $fromCurrency): self
    {
        $this->fromCurrency = $fromCurrency;

        return $this;
    }

    /**
     * @param  string  $toCurrency
     *
     * @return ExchangeRates
     */
    public function setTo(string $toCurrency): self
    {
        $this->toCurrency = $toCurrency;

        return $this;
    }

    /**
     * @return string
     */
    protected function getFullEndpoint(): string
    {
        return str_replace(
            '{from}',
            $this->fromCurrency,
            str_replace(
                '{to}',
                $this->toCurrency,
                self::ENDPOINT
            )
        );
    }
}
