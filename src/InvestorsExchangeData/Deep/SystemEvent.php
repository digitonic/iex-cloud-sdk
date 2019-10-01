<?php

namespace Digitonic\IexCloudSdk\InvestorsExchangeData\Deep;

use Digitonic\IexCloudSdk\Contracts\IEXCloud;
use Digitonic\IexCloudSdk\Requests\BaseGet;

class SystemEvent extends BaseGet
{
    const ENDPOINT = 'deep/system-event';

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
