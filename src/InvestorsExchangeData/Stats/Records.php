<?php

namespace Digitonic\IexCloudSdk\InvestorsExchangeData\Stats;

use Digitonic\IexCloudSdk\Contracts\IEXCloud;
use Digitonic\IexCloudSdk\Requests\BaseGet;

class Records extends BaseGet
{
    const ENDPOINT = 'stats/records';

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
