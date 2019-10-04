<?php

namespace Digitonic\IexCloudSdk\ReferenceData;

use Digitonic\IexCloudSdk\Contracts\IEXCloud;
use Digitonic\IexCloudSdk\Exceptions\WrongData;
use Digitonic\IexCloudSdk\Requests\BaseGet;

class USHolTradeDates extends BaseGet
{
    const ENDPOINT = 'ref-data/us/dates/{type}/{direction}/{last}/{startDate}';

    /**
     * @var string
     */
    protected $direction = 'next';

    /**
     * @var string
     */
    protected $type = 'trade';

    /**
     * @var int
     */
    protected $last = 1;

    /**
     * @var string
     */
    protected $startDate = '';

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
     * @param  string  $type
     *
     * @return USHolTradeDates
     */
    public function setType(string $type): self
    {
        $this->validateInput($type, '/(trade|holiday)/mi', 'Type can be trade or holiday');

        $this->type = $type;

        return $this;
    }

    /**
     * @param  string  $direction
     *
     * @return USHolTradeDates
     */
    public function setDirection(string $direction): self
    {
        $this->validateInput($direction, '/(next|last)/mi', 'Direction can be next or last');

        $this->direction = $direction;

        return $this;
    }

    /**
     * @param  string  $last
     *
     * @return USHolTradeDates
     */
    public function setLast(string $last): self
    {
        $this->last = (int) $last;

        return $this;
    }

    /**
     * @param  string  $startDate
     *
     * @return USHolTradeDates
     */
    public function setStartDate(string $startDate): self
    {
        $this->validateInput(
            $startDate,
            '/(20\d{2})(\d{2})(\d{2})/mi',
            'Format date to use YYYYMMDD to fetch sentiment data.'
        );

        $this->startDate = $startDate;

        return $this;
    }

    /**
     * @return string
     */
    protected function getFullEndpoint(): string
    {
        return self::ENDPOINT;
    }

    /**
     * @param  string  $input
     * @param  string  $pattern
     * @param  string  $errorMessage
     */
    private function validateInput(string $input, string $pattern, string $errorMessage): void
    {
        preg_match_all($pattern, $input, $matches, PREG_SET_ORDER, 0);

        if (empty($matches)) {
            throw WrongData::invalidValuesProvided($errorMessage);
        }
    }
}
