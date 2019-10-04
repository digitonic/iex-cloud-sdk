<?php

namespace Digitonic\IexCloudSdk\ReferenceData;

use Digitonic\IexCloudSdk\Contracts\IEXCloud;
use Digitonic\IexCloudSdk\Exceptions\WrongData;
use Digitonic\IexCloudSdk\Requests\BaseGet;

class RegionSymbols extends BaseGet
{
    const ENDPOINT = 'ref-data/region/{region}/symbols';

    /**
     * @var string
     */
    private $region;

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
     * @param  string  $region
     *
     * @return RegionSymbols
     */
    public function setRegion(string $region): self
    {
        $this->region = $region;

        return $this;
    }

    /**
     * @return string
     */
    protected function getFullEndpoint(): string
    {
        return str_replace('{region}', $this->region, self::ENDPOINT);
    }

    /**
     * @return bool|void
     */
    protected function validateParams(): void
    {
        if (empty($this->region)) {
            throw WrongData::invalidValuesProvided(
                'Region required using 2 letter case insensitive string of country codes using ISO 3166-1 alpha-2'
            );
        }
    }
}
