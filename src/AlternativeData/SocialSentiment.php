<?php

namespace Digitonic\IexCloudSdk\AlternativeData;

use Digitonic\IexCloudSdk\Contracts\IEXCloud;
use Digitonic\IexCloudSdk\Exceptions\WrongData;
use Digitonic\IexCloudSdk\Requests\BaseRequest;

class SocialSentiment extends BaseRequest
{
    const ENDPOINT = 'stock/{symbol}/sentiment/{type}/{date}';

    /**
     * @var string
     */
    private $type = 'daily';

    /**
     * @var string
     */
    private $date;

    /**
     * Create constructor.
     *
     * @param  IEXCloud  $api
     */
    public function __construct(IEXCloud $api)
    {
        parent::__construct($api);
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function setDate(string $date): self
    {
        $this->validateDate($date);

        $this->date = $date;

        return $this;
    }

    /**
     * @return string
     */
    protected function getFullEndpoint(): string
    {
        $endpoint = str_replace('{symbol}', $this->symbol, self::ENDPOINT);
        $endpoint = str_replace('{type}', $this->type, $endpoint);
        $endpoint = str_replace('{date}', $this->date, $endpoint);

        return $endpoint;

    }

    /**
     * @return bool|void
     */
    protected function validateParams(): void
    {
        if (empty($this->symbol)) {
            throw WrongData::invalidValuesProvided('Please provide a symbol to query!');
        }
    }

    private function validateDate(string $date)
    {
        $re = '/(20\d{2})(\d{2})(\d{2})/mi';

        preg_match_all($re, $date, $matches, PREG_SET_ORDER, 0);

        if (empty($matches)) {
            throw WrongData::invalidValuesProvided('Format date to use YYYYMMDD to fetch sentiment data.');
        }
    }
}
