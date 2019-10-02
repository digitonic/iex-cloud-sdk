<?php

namespace Digitonic\IexCloudSdk\Tests\ReferenceData;

use Digitonic\IexCloudSdk\Facades\ReferenceData\Search;
use Digitonic\IexCloudSdk\Facades\ReferenceData\Symbols;
use Digitonic\IexCloudSdk\Tests\BaseTestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Collection;

class SearchTest extends BaseTestCase
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

        $this->response = new Response(200, [], '[{ "symbol": "AAPL", "securityName": ".eA plpcnI", "securityType": "sc", "region": "US", "exchange": "NAS"},{ "symbol": "APLE", "securityName": "cRl  yHatEiIslp tneoipAIpT", "securityType": "cs", "region": "US", "exchange": "SYN"},{ "symbol": "APRU", "securityName": "Cem phplnas, pcIAoynu R.", "securityType": "cs", "region": "US", "exchange": "COT"},{ "symbol": "AGPL", "securityName": "e.c nHeplGderInli opAgn, ","securityType": "sc","region": "US","exchange": "COT"},{ "symbol": "APGN-ID", "securityName": "ercpngeA pllpe", "securityType": "cs", "region": "IE", "exchange": "BDU"},{ "symbol": "APGN-LN", "securityName": "rApeelep pgncl", "securityType": "sc","region": "GB", "exchange": "OLN"},{"symbol": "AAPL-MM","securityName": " p.plecAnI","securityType": "sc","region": "MX","exchange": "XME"},{ "symbol": "APC-GY", "securityName": "pelA .pncI", "securityType": "sc", "region": "DE", "exchange": "ETR"},{"symbol": "500014-IB","securityName": "ilipdem eFintepLc Ana","securityType": "cs","region": "IN","exchange": "BMO"},{"symbol": "511339-IB","securityName": "trpC.L.potir ede pCAld ","securityType": "sc","region": "IN","exchange": "OMB"}]');
    }

    /** @test */
    public function it_can_query_the_search_endpoint()
    {
        $mock = new MockHandler([$this->response]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $iexApi = new \Digitonic\IexCloudSdk\Client($client);

        $search = new \Digitonic\IexCloudSdk\ReferenceData\Search($iexApi);

        $response = $search->setTerm('apple')->send();

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(10, $response);
        $this->assertEquals('AAPL', $response->first()->symbol);
        $this->assertEquals('US', $response->first()->region);
    }

    /** @test */
    public function it_can_call_the_facade()
    {
        $this->app['config']->set('iex-cloud-sdk.base_url', 'https://cloud.iexapis.com/v1');
        $this->app['config']->set('iex-cloud-sdk.secret_key', 'KxDMt9GNVgu6fJUOG0UjH3d4kjZPTxFiXd5RnPhUD8Qz1Q2esNVIFfqmrqRD');
        $this->app['config']->set('iex-cloud-sdk.public_key', 'KxDMt9GNVgu6fJUOG0UjH3d4kjZPTxFiXd5RnPhUD8Qz1Q2esNVIFfqmrqRD');

        Search::shouldReceive('setTerm')
            ->once()
            ->andReturnSelf();

        Search::setTerm('SNAP');

    }
}
