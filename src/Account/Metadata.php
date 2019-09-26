<?php

namespace Digitonic\IexCloudSdk\Account;

use Digitonic\IexCloudSdk\Contracts\IEXCloud;
use Digitonic\IexCloudSdk\Requests\BaseGet;

class Metadata extends BaseGet
{
    const ENDPOINT = 'account/metadata';

    /**
     * Create constructor.
     *
     * @param  IEXCloud  $api
     */
    public function __construct(IEXCloud $api)
    {
        parent::__construct($api);
    }
}
