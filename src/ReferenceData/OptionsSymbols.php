<?php

namespace Digitonic\IexCloudSdk\ReferenceData;

use Digitonic\IexCloudSdk\Contracts\IEXCloud;
use Digitonic\IexCloudSdk\Requests\BaseRequest;

class OptionsSymbols extends BaseRequest
{
    const ENDPOINT = 'ref-data/options/symbols';

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
        return self::ENDPOINT;
    }
}
