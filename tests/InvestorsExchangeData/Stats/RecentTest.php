<?php

namespace Digitonic\IexCloudSdk\Tests\InvestorsExchangeData\Stats;

use Digitonic\IexCloudSdk\Facades\InvestorsExchangeData\Stats\Recent;
use Digitonic\IexCloudSdk\Tests\BaseTestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Collection;

class RecentTest extends BaseTestCase
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

        $this->response = new Response(200, [], '[{"date": "2019-09-30","volume": 171630638,"routedVolume": 21267501,"marketShare": 0.02674,"isHalfday": false,"litVolume": 28905926},{"date": "2019-09-27","volume": 191810695,"routedVolume": 25103519,"marketShare": 0.02892,"isHalfday": false,"litVolume": 31583117},{"date": "2019-09-26","volume": 174170764,"routedVolume": 25161383,"marketShare": 0.02859,"isHalfday": false,"litVolume": 27865309},{"date": "2019-09-25","volume": 200833226,"routedVolume": 25026327,"marketShare": 0.02973,"isHalfday": false,"litVolume": 31342279}]');
    }

    /** @test */
    public function it_can_query_the_deep_trades_endpoint()
    {
        $mock = new MockHandler([$this->response]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $iexApi = new \Digitonic\IexCloudSdk\Client($client);

        $recent = new \Digitonic\IexCloudSdk\InvestorsExchangeData\Stats\Recent($iexApi);

        $response = $recent->send();

        $this->assertInstanceOf(Collection::class, $response);

        $response = $response->toArray();
        $this->assertCount(4, $response);
        $this->assertSame('2019-09-30', $response[0]->date);
    }

    /** @test */
    public function it_can_call_the_facade()
    {
        $this->app['config']->set('iex-cloud-sdk.base_url', 'https://cloud.iexapis.com/v1');
        $this->app['config']->set('iex-cloud-sdk.secret_key', 'KxDMt9GNVgu6fJUOG0UjH3d4kjZPTxFiXd5RnPhUD8Qz1Q2esNVIFfqmrqRD');
        $this->app['config']->set('iex-cloud-sdk.public_key', 'KxDMt9GNVgu6fJUOG0UjH3d4kjZPTxFiXd5RnPhUD8Qz1Q2esNVIFfqmrqRD');

        Recent::shouldReceive('send')
            ->once()
            ->andReturn(collect(json_decode($this->response->getBody()->getContents())));

        Recent::send();
    }
}
