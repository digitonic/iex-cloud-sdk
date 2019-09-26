<?php

namespace Digitonic\IexCloudSdk;

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
     */
    public function send(RequestInterface $request, array $options = []): ResponseInterface
    {
        try {
            return $this->client->send($request);
        }
        catch (ClientException $e) {
            throw WrongData::invalidValuesProvided($e);
        }
    }
}
