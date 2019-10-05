<?php

namespace Digitonic\IexCloudSdk\Tests\Account;

use Digitonic\IexCloudSdk\Tests\BaseTestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Collection;

class MetadataTest extends BaseTestCase
{
    /** @test */
    public function it_can_query_the_meta_data_endpoint()
    {
        $mock = new MockHandler([
            new Response(200, [], '{"payAsYouGoEnabled": false,"effectiveDate": 1578231734584,"subscriptionTermType": "mlotynh","tierName": "sartt","messageLimit": 508040,"messagesUsed": 13280,"circuitBreaker": null}')
        ]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $iexApi = new \Digitonic\IexCloudSdk\Client($client);

        $metadata = new \Digitonic\IexCloudSdk\Account\Metadata($iexApi);

        $response = $metadata->get();

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(7, $response);
        $this->assertEquals(false, $response['payAsYouGoEnabled']);
        $this->assertEquals('1578231734584', $response['effectiveDate']);
    }
}
