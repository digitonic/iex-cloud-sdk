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
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->response = new Response(200, [], '{"bids": [{"price": "8621.32","size": "0.034519","timestamp": 1642342503636}],"asks": [{"price": "8611.71","size": "0.010457","timestamp": 1613097668001}]}');

        $this->client = $this->setupMockedClient($this->response);
    }

    /** @test */
    public function it_should_fail_without_a_symbol()
    {
        $crypto = new \Digitonic\IexCloudSdk\AlternativeData\Crypto\Book($this->client);

        $this->expectException(WrongData::class);

        $crypto->get();
    }

    /** @test */
    public function it_can_query_the_crypto_endpoint()
    {
        $crypto = new \Digitonic\IexCloudSdk\AlternativeData\Crypto\Book($this->client);

        $response = $crypto->setSymbol('aapl')->get();

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
        $this->setConfig();

        Book::shouldReceive('setSymbol')
            ->once()
            ->andReturnSelf();

        Book::setSymbol('aapl');
    }
}
