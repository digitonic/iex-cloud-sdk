<?php

namespace Digitonic\IexCloudSdk\Tests\Account;

use Digitonic\IexCloudSdk\Tests\BaseTestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Collection;

class UsageTest extends BaseTestCase
{
    /** @test */
    public function it_can_query_the_usage_endpoint()
    {
        $mock = new MockHandler([
            new Response(200, [], '{"messages": {"dailyUsage": {"20190925": "163820"},"monthlyUsage": 159621,"monthlyPayAsYouGo": 0,"tokenUsage": {"Tsk_ca9224c230a611e9958142010a80043c": "162364"},"keyUsage": {"ACCOUNT_USAGE": "0","KEY_STATS": "15","ADVANCED_KEY_STATS": "6107","COMPANY": "2","STOCK_QUOTE": "52","CORE_NEWS": "31","OPTIONS_EOD": "1029","EARNINGS": "2090","FINANCIALS": "10222","TODAY_IPOS": "0","PRICE_ONLY": "1","PREVIOUS": "142341","REF_DATA": "104"}},"rules": []}')
        ]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $iexApi = new \Digitonic\IexCloudSdk\Client($client);

        $usage = new \Digitonic\IexCloudSdk\Account\Usage($iexApi);

        $response = $usage->get();

        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(2, $response);
        $this->assertEquals('159621', $response['messages']->monthlyUsage);
    }
}
