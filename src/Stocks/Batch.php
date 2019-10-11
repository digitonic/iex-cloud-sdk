<?php

namespace Digitonic\IexCloudSdk\Stocks;

use Digitonic\IexCloudSdk\Contracts\IEXCloud;
use Digitonic\IexCloudSdk\Exceptions\WrongData;
use Digitonic\IexCloudSdk\Requests\BaseRequest;

class Batch extends BaseRequest
{
    const ENDPOINT = 'stock/{symbol}/batch?';

    protected $symbol = 'market';

    /**
     * @var string
     */
    private $symbols;

    /**
     * @var string
     */
    private $types;

    /**
     * @var string
     */
    private $range;

    /**
     * Create constructor.
     *
     * @param  IEXCloud  $api
     */
    public function __construct(IEXCloud $api)
    {
        parent::__construct($api);
    }

    public function setSymbols(...$symbols): self
    {
        if (count($symbols) === 1) {
            $this->symbol = $symbols[0];
        }

        $this->symbols = implode(',', $symbols);

        return $this;
    }

    public function setTypes(...$types): self
    {
        $this->types = implode(',', $types);

        return $this;
    }

    public function setRange(string $range): self
    {
        $this->range = $range;

        return $this;
    }

    /**
     * @return string
     */
    public function getFullEndpoint(): string
    {
        $params = [
            'types' => $this->types,
        ];

        if (count(explode(',', $this->symbols)) > 1) {
            $params['symbols'] = $this->symbols;
        }

        if ($this->range) {
            if (in_array('chart', explode(',', $this->types))) {
                $params['range'] = $this->range;
            }
        }

        $query = http_build_query($params);

        $endpoint = str_replace('{symbol}', $this->symbol, self::ENDPOINT);
        $endpoint = $endpoint . $query;

        return $endpoint;
    }

    /**
     * @return bool|void
     * @throws WrongData
     */
    protected function validateParams(): void
    {
        if (empty($this->symbols)) {
            throw WrongData::invalidValuesProvided('Please provide a symbol to query!');
        }

        if (empty($this->types)) {
            throw WrongData::invalidValuesProvided(
                'Types Required: comma delimited list of endpoints to call. ' .
                'The names should match the individual endpoint names. Limited to 10 endpoints.'
            );
        }
    }
}
