<?php

namespace Digitonic\IexCloudSdk\Tests\AlternativeData\Crypto;

use Digitonic\IexCloudSdk\Exceptions\WrongData;
use Digitonic\IexCloudSdk\Facades\AlternativeData\Crypto\Book;
use Digitonic\IexCloudSdk\Tests\BaseTestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Collection;

class BookTest extends BaseTestCase
{
    /**
     * @var Response
     */
    private $response;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->response = new Response(200, [], '{"bids": [{"price": "8621.32","size": "0.034519","timestamp": 1642342503636}],"asks": [{"price": "8611.71","size": "0.010457","timestamp": 1613097668001}]}');
    }

    /** @test */
    public function it_should_fail_without_a_symbol()
    {
        $mock = new MockHandler([$this->response]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $iexApi = new \Digitonic\IexCloudSdk\Client($client);

        $crypto = new \Digitonic\IexCloudSdk\AlternativeData\Crypto\Book($iexApi);

        $this->expectException(WrongData::class);

        $crypto->send();
    }

    /** @test */
    public function it_can_query_the_crypto_endpoint()
    {
        $mock = new MockHandler([$this->response]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $iexApi = new \Digitonic\IexCloudSdk\Client($client);

        $crypto = new \Digitonic\IexCloudSdk\AlternativeData\Crypto\Book($iexApi);

        $response = $crypto->setSymbol('aapl')->send();

        $this->assertInstanceOf(Collection::class, $response);

        $response = $response->toArray();
        $this->assertCount(2, $response);
        $this->assertEquals('8621.32', $response['bids'][0]->price);
        $this->assertEquals('0.034519', $response['bids'][0]->size);
        $this->assertEquals(1642342503636, $response['bids'][0]->timestamp);
    }

    /** @test */
    public function it_can_call_the_facade()
    {
        $this->app['config']->set('iex-cloud-sdk.base_url', 'https://cloud.iexapis.com/v1');
        $this->app['config']->set('iex-cloud-sdk.secret_key', 'KxDMt9GNVgu6fJUOG0UjH3d4kjZPTxFiXd5RnPhUD8Qz1Q2esNVIFfqmrqRD');
        $this->app['config']->set('iex-cloud-sdk.public_key', 'KxDMt9GNVgu6fJUOG0UjH3d4kjZPTxFiXd5RnPhUD8Qz1Q2esNVIFfqmrqRD');

        Book::shouldReceive('setSymbol')
            ->once()
            ->andReturnSelf();

        Book::setSymbol('aapl');
    }
}
