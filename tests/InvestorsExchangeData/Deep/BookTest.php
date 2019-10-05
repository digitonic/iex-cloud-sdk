<?php

namespace Digitonic\IexCloudSdk\Tests\InvestorsExchangeData\Deep;

use Digitonic\IexCloudSdk\Exceptions\WrongData;
use Digitonic\IexCloudSdk\Facades\InvestorsExchangeData\Deep\Book;
use Digitonic\IexCloudSdk\Tests\BaseTestCase;
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

        $this->response = new Response(200, [], '{"AAPL": {"bids": [],"asks": []}}');

        $this->client = $this->setupMockedClient($this->response);
    }

    /** @test */
    public function it_should_fail_without_a_symbol()
    {
        $book = new \Digitonic\IexCloudSdk\InvestorsExchangeData\Deep\Book($this->client);

        $this->expectException(WrongData::class);

        $book->get();
    }

    /** @test */
    public function it_can_query_the_deep_book_endpoint()
    {
        $book = new \Digitonic\IexCloudSdk\InvestorsExchangeData\Deep\Book($this->client);

        $response = $book->setSymbol('aapl')->get();

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
