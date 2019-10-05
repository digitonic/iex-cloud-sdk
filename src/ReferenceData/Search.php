<?php

namespace Digitonic\IexCloudSdk\ReferenceData;

use Digitonic\IexCloudSdk\Contracts\IEXCloud;
use Digitonic\IexCloudSdk\Requests\BaseRequest;

class Search extends BaseRequest
{
    const ENDPOINT = 'search/{term}';

    /**
     * @var string
     */
    protected $term;

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
     * @param  string  $term
     *ß
     *
     * @return Search
     */
    public function setTerm(string $term): self
    {
        $this->term = $term;

        return $this;
    }

    /**
     * @return string
     */
    protected function getFullEndpoint(): string
    {
        return str_replace('{term}', $this->term, self::ENDPOINT);
    }
}
