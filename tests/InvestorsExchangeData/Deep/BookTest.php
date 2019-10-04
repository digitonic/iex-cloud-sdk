<?php

namespace Digitonic\IexCloudSdk\Tests\InvestorsExchangeData\Deep;

use Digitonic\IexCloudSdk\Exceptions\WrongData;
use Digitonic\IexCloudSdk\Facades\InvestorsExchangeData\Deep\Book;
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

        $this->response = new Response(200, [], '{"AAPL": {"bids": [],"asks": []}}');
    }

    /** @test */
    public function it_should_fail_without_a_symbol()
    {
        $mock = new MockHandler([$this->response]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $iexApi = new \Digitonic\IexCloudSdk\Client($client);

        $book = new \Digitonic\IexCloudSdk\InvestorsExchangeData\Deep\Book($iexApi);

        $this->expectException(WrongData::class);

        $book->send();
    }

    /** @test */
    public function it_can_query_the_deep_book_endpoint()
    {
        $mock = new MockHandler([$this->response]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $iexApi = new \Digitonic\IexCloudSdk\Client($client);

        $book = new \Digitonic\IexCloudSdk\InvestorsExchangeData\Deep\Book($iexApi);

        $response = $book->setSymbol('aapl')->send();

        $this->assertInstanceOf(Collection::class, $response);

        $response = $response->toArray();
        $this->assertCount(1, $response);
        $this->assertCount(2, (array) $response['AAPL']);
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
