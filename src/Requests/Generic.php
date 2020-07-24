<?php

namespace Digitonic\IexCloudSdk\Requests;

use Digitonic\IexCloudSdk\Contracts\IEXCloud;

class Generic extends BaseRequest
{
    private $endpoint = '';
    private $params   = '';

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
     * @return string
     */
    protected function getFullEndpoint(): string
    {
        return $this->endpoint . ($this->params ? '?' . http_build_query($this->params) : '');
    }

    /**
     * @return bool|void
     */
    protected function validateParams(): void
    {
        if (empty($this->endpoint)) {
            throw WrongData::invalidValuesProvided('Please provide endpoint!');
        }
    }

    /**
     * Set endpoint
     *
     * @param $endpoint
     * @return Generic
     */
    public function setEndpoint($endpoint) {
        $this->endpoint = $endpoint;
        return $this;
    }

    /**
     * Set params
     *
     * @param $params
     * @return Generic
     */
    public function setParams(array $params = []) {
        $this->params = $params;
        return $this;
    }
}
