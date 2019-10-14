<?php

namespace Digitonic\IexCloudSdk\Tests\Stocks;

use Digitonic\IexCloudSdk\Exceptions\WrongData;
use Digitonic\IexCloudSdk\Facades\Stocks\Company;
use Digitonic\IexCloudSdk\Tests\BaseTestCase;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Collection;

class CompanyTest extends BaseTestCase
{
    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->response = new Response(200, [], '{
    "symbol": "AAPL",
    "companyName": "Apple, Inc.",
    "exchange": "NASDAQ",
    "industry": "Telecommunications Equipment",
    "website": "http://www.apple.com",
    "description": "Apple, Inc. engages in designing, manufacturing, and marketing of mobile communication, media devices, personal computers, and portable digital music players. It operates through the following geographical segments: Americas, Europe, Greater China, Japan, and Rest of Asia Pacific. The Americas segment includes North and South America. The Europe segment consists of European countries, as well as India, the Middle East, and Africa. The Greater China segment comprises of China, Hong Kong, and Taiwan. The Rest of Asia Pacific segment includes Australia and Asian countries. Its products and services include iPhone, iPad, Mac, iPod, Apple Watch, Apple TV, a portfolio of consumer and professional software applications, iPhone OS (iOS), OS X and watchOS operating systems, iCloud, Apple Pay and a range of accessory, service and support offerings. Apple was founded by Steven Paul Jobs, Ronald Gerald Wayne, and Stephen G. Wozniak on April 1, 1976 and is headquartered in Cupertino, CA.",
    "CEO": "Timothy Donald Cook",
    "securityName": "Apple Inc.",
    "issueType": "cs",
    "sector": "Electronic Technology",
    "primarySicCode": 3663,
    "employees": 132000,
    "tags": [
        "Electronic Technology",
        "Telecommunications Equipment"
    ],
    "address": "One Apple Park Way",
    "address2": null,
    "state": "CA",
    "city": "Cupertino",
    "zip": "95014-2083",
    "country": "US",
    "phone": "1.408.974.3123"
}');

        $this->client = $this->setupMockedClient($this->response);
    }

    /** @test */
    public function it_should_fail_without_a_symbol()
    {
        $logo = new \Digitonic\IexCloudSdk\Stocks\Company($this->client);

        $this->expectException(WrongData::class);

        $logo->get();
    }

    /** @test */
    public function it_can_query_the_company_endpoint()
    {
        $logo = new \Digitonic\IexCloudSdk\Stocks\Company($this->client);

        $response = $logo->setSymbol('aapl')->get();
        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(20, $response);

        $response = $response->toArray();
        $this->assertEquals('AAPL', $response['symbol']);
        $this->assertEquals('Apple, Inc.', $response['companyName']);
        $this->assertEquals('NASDAQ', $response['exchange']);
    }

    /** @test */
    public function it_can_call_the_facade()
    {
        $this->setConfig();

        Company::shouldReceive('setSymbol')
            ->once()
            ->andReturnSelf();

        Company::setSymbol('aapl');
    }
}
