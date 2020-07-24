<?php

namespace Digitonic\IexCloudSdk;

use Illuminate\Support\Arr;
use GuzzleHttp\Client as Guzzle;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Digitonic\IexCloudSdk\Contracts\IEXCloud;
use Digitonic\IexCloudSdk\Exceptions\WrongData;

class Client implements IEXCloud
{
    /**
     * @var Guzzle|null
     */
    private $client = null;

    /**
     * Client constructor.
     *
     * @param  Guzzle  $client
     */
    public function __construct(Guzzle $client)
    {
        $this->client = $client;
    }

    /**
     * @param  RequestInterface  $request
     * @param  array  $options
     *
     * @return ResponseInterface
     * @throws GuzzleException
     * @throws WrongData
     */
    public function send(RequestInterface $request, array $options = []): ResponseInterface
    {
        try {
            $options['query'] = $this->mergeQuery($request);
            return $this->client->send($request);
        }
        catch (ClientException $e) {
            throw WrongData::invalidValuesProvided($e->getMessage());
        }
    }

    /**
     * Merge the global query with current query (if has it)
     *
     * @param RequestInterface $request
     * @return array
     */
    private function mergeQuery(RequestInterface $request) {
        $currentQueryArray = Arr::get($this->client->getConfig(), 'query');
        $newQueryArray = [];
        if($query = $request->getUri()->getQuery()) {
            parse_str($query, $newQueryArray);
        }

        return array_merge($currentQueryArray, $newQueryArray);
    }
}
