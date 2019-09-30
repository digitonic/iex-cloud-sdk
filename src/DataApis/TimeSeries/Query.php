<?php

namespace Digitonic\IexCloudSdk\DataApis\TimeSeries;

use Digitonic\IexCloudSdk\Contracts\IEXCloud;
use Digitonic\IexCloudSdk\Exceptions\WrongData;
use Digitonic\IexCloudSdk\Requests\BaseGet;

class Query extends BaseGet
{
    const ENDPOINT = 'time-series/{id}/{key}/{subKey}';

    /**
     * @var string
     */
    protected $id = '';

    /**
     * @var string
     */
    protected $key = '';

    /**
     * @var string
     */
    protected $subKey = '';

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
     * @param  string  $id
     *
     * @return Query
     */
    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @param  string  $key
     *
     * @return Query
     */
    public function setKey(string $key): self
    {
        $this->key = $key;

        return $this;
    }

    /**
     * @param  string  $subKey
     *
     * @return Query
     */
    public function setSubKey(string $subKey): self
    {
        $this->subKey = $subKey;

        return $this;
    }

    /**
     * @return string
     */
    protected function getFullEndpoint(): string
    {
        $endpoint = str_replace('{id}', $this->id, self::ENDPOINT);
        $endpoint = str_replace('{key}', $this->key, $endpoint);
        $endpoint = str_replace('{subKey}', $this->subKey, $endpoint);

        return $endpoint;
    }

    /**
     * @return bool|void
     */
    protected function validateParams()
    {
        if (empty($this->id)) {
            throw WrongData::invalidValuesProvided('ID required to identify a time series dataset.');
        }

        if (empty($this->key)) {
            throw WrongData::invalidValuesProvided(
                'Key required to identify data within a dataset. A common example is a symbol such as AAPL.'
            );
        }
    }
}
