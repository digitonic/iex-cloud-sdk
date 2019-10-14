<?php

namespace Digitonic\IexCloudSdk\Tests\Stocks;

use Digitonic\IexCloudSdk\Exceptions\WrongData;
use Digitonic\IexCloudSdk\Facades\Stocks\News;
use Digitonic\IexCloudSdk\Tests\BaseTestCase;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Collection;

class NewsTest extends BaseTestCase
{
    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->response = new Response(200, [], '[
    {
        "datetime": 1571050800000,
        "headline": "Top Apple Executives Sold Millions of Dollars of Stock",
        "source": "Barron\'s",
        "url": "https://cloud.iexapis.com/v1/news/article/2207f452-82d4-4309-8405-fecc2dce6604",
        "summary": "The chief financial officer and chief operating officer cashed in through planned transactions as Apple stock traded to 52-week intraday highs.",
        "related": "AAPL",
        "image": "https://cloud.iexapis.com/v1/news/image/2207f452-82d4-4309-8405-fecc2dce6604",
        "lang": "en",
        "hasPaywall": true
    },
    {
        "datetime": 1571031348000,
        "headline": "iPhone 11 takes Apple ahead of Microsoft in $1 trillion market cap",
        "source": "The Economic Times India",
        "url": "https://cloud.iexapis.com/v1/news/article/81e4d0fc-2b1d-453a-b6fe-f4f831a0df90",
        "summary": "Apple stock has reached $236.21 to beat the previous high set just over a year ago.",
        "related": "AAPL",
        "image": "https://cloud.iexapis.com/v1/news/image/81e4d0fc-2b1d-453a-b6fe-f4f831a0df90",
        "lang": "en",
        "hasPaywall": false
    },
    {
        "datetime": 1571023845000,
        "headline": "Dow Jones Futures: Will China Trade Deal Spur Stock Market Rally? 5 Giants Near Buy Points",
        "source": "ACI Information Group",
        "url": "https://cloud.iexapis.com/v1/news/article/2543eb67-6fc9-4e0c-aec8-128fae3e3d47",
        "summary": "Stock futures: Will the China trade deal spur the stock market to record highs like Apple? Microsoft, Google, Nvidia, Facebook, Visa are near buys.",
        "related": "AAPL",
        "image": "https://cloud.iexapis.com/v1/news/image/2543eb67-6fc9-4e0c-aec8-128fae3e3d47",
        "lang": "en",
        "hasPaywall": false
    },
    {
        "datetime": 1570986000000,
        "headline": "Apple is walking a perilous tightrope as it tries to keep China onside",
        "source": "The Telegraph",
        "url": "https://cloud.iexapis.com/v1/news/article/c096e7e3-f26a-4736-b9b8-8cb58a152f9c",
        "summary": "Mark Zuckerberg must be relieved.",
        "related": "AAPL",
        "image": "https://cloud.iexapis.com/v1/news/image/c096e7e3-f26a-4736-b9b8-8cb58a152f9c",
        "lang": "en",
        "hasPaywall": false
    },
    {
        "datetime": 1570901400000,
        "headline": "A Mumbai-based hair oil firm is on a mission to win the slump over",
        "source": "The Economic Times India",
        "url": "https://cloud.iexapis.com/v1/news/article/53981060-590f-49bd-b348-0216f67ee5e1",
        "summary": "Corporate transformations are best not done during an economic slowdown. But Marico Ltd is unperturbed as it has been a company in transition for most of its life. After all, the Mumbai-based FMCG company with sales exceeding $1 billion (consolidated total income of Rs 7,437 crore in 2018-19) had created a branded safflower and coconut oil business out of a commodity play in the 1970s and made an equally bold move into value-added products in the late 1990s.Innovation has been the credo for the company, says Chairman and promoter of Marico Harsh Mariwala, and it can also help the company sail through the choppy waters of a slowdown in demand growth. Last week, as his interview with ET Magazine came to an end, Mariwala insisted on displaying his favourite PowerPoint slides on corporate transformation. Organised in pairs of words, the slides showed how the mindset in Marico had shifted from “conservative” to “risktaker” or from “steady growth” to “fast-track”. It explained how business transformation meant moving from “low margin” to “high margin”, “local” to “global” and “oils” to “FMCG”.",
        "related": "AAPL",
        "image": "https://cloud.iexapis.com/v1/news/image/53981060-590f-49bd-b348-0216f67ee5e1",
        "lang": "en",
        "hasPaywall": false
    },
    {
        "datetime": 1570897020000,
        "headline": "Benzinga\'s Bulls And Bears Of The Week: Apple, Boeing, Facebook, Nike And More",
        "source": "Benzinga",
        "url": "https://cloud.iexapis.com/v1/news/article/f9efb9e6-b06b-422d-9c15-b30705971641",
        "summary": "Benzinga has examined the prospects for many investor favorite stocks over the past week. Bullish calls included the iPhone maker, a mining giant and a …",
        "related": "AAPL",
        "image": "https://cloud.iexapis.com/v1/news/image/f9efb9e6-b06b-422d-9c15-b30705971641",
        "lang": "en",
        "hasPaywall": false
    },
    {
        "datetime": 1570842325000,
        "headline": "Woman files class action suit over lack of tampons in NYC jails",
        "source": "New York Post",
        "url": "https://cloud.iexapis.com/v1/news/article/441eb3b8-525b-43e3-ad42-b1e27859d131",
        "summary": "A woman busted in Queens has filed a class action suit against the city alleging that the Big Apple’s 77 police precinct houses don’t carry tampons and pads for female prisoners. Jennifer Flores, 24, was on her period when she was collared for obstruction on Oct. 12, 2016 and says she was forced to bleed through…",
        "related": "AAPL",
        "image": "https://cloud.iexapis.com/v1/news/image/441eb3b8-525b-43e3-ad42-b1e27859d131",
        "lang": "en",
        "hasPaywall": false
    },
    {
        "datetime": 1570831680000,
        "headline": "I went to the New York City Oktoberfest said to be the best outside of Munich, and I was not disappointed",
        "source": "Business Insider",
        "url": "https://cloud.iexapis.com/v1/news/article/7aa71f30-aaa6-4d98-b170-575cb0e88d4e",
        "summary": "Oktoberfest is an annual beer festival held in Munich , Germany , that draws over six million attendees from around the world. Munich on the East River , organized by the owners of the East Village biergarten Zum Schneider , is an annual event held in New York City . Insider sent me to check out what\'s known as the most authentic Oktoberfest this side of Bavaria . Authentic Bavarian clothing, food, music, and — of course — beer, are all important staples of the festival. Visit Insider\'s homepage for more stories . Munich on the East River is known as the most authentic Oktoberfest this side of Bavaria. Organized by the owners of East Village biergarten Zum Schneider, the annual festival takes place by the river at the intersection of East 23rd St. and FDR Drive. The festival runs from September 27 through October 6, and includes a fully decorated, traditional Oktoberfest tent with original furniture, food and drink tents, and a live band. This year, around 8,000 people walked through the doors over the course of the festival.",
        "related": "AAPL",
        "image": "https://cloud.iexapis.com/v1/news/image/7aa71f30-aaa6-4d98-b170-575cb0e88d4e",
        "lang": "en",
        "hasPaywall": false
    },
    {
        "datetime": 1570828260000,
        "headline": "How to change your PS4 background to a custom image",
        "source": "Business Insider",
        "url": "https://cloud.iexapis.com/v1/news/article/f4c2ccf7-ad1d-4292-82fd-025b9b3bdbc8",
        "summary": "You can change your PS4 background to a custom image in just a few steps. First, you\'ll have to put the image you want to use on a USB drive in a folder called Images. You can then go to the Themes section in your PS4 Settings to upload images from your USB and change your background. Visit Business Insider\'s homepage for more stories . If you\'re tired of that swirly blue background on your PS4 \'s home screen, you don\'t have to live with it any longer. You can replace it with any image you like – your own photos or anything you find online. In fact, Sony put about two dozen gorgeous game images on its blog that you can download and use if you like. Whatever photos, screenshots, or images you use, remember that for best results, you\'ll want to use images that are either 1920 x 1080 pixels or 3840 x 2160 pixels, which matches the resolution and aspect ratio of a PS4 and PS4 Pro , respectively. Check out the products mentioned in this article: PlayStation 4 (From $299.99 at Best Buy) How to change your PS4 background 1.",
        "related": "AAPL",
        "image": "https://cloud.iexapis.com/v1/news/image/f4c2ccf7-ad1d-4292-82fd-025b9b3bdbc8",
        "lang": "en",
        "hasPaywall": false
    },
    {
        "datetime": 1570823818000,
        "headline": "Apple\'s China controversy is the price of doing business",
        "source": "ACI Information Group",
        "url": "https://cloud.iexapis.com/v1/news/article/818d0dd4-4ae4-4611-9158-dbe8e090e763",
        "summary": "Apple\'s recent China controversy won\'t be the last the company faces while doing business in the country.",
        "related": "AAPL",
        "image": "https://cloud.iexapis.com/v1/news/image/818d0dd4-4ae4-4611-9158-dbe8e090e763",
        "lang": "en",
        "hasPaywall": false
    }
]');

        $this->client = $this->setupMockedClient($this->response);
    }

    /** @test */
    public function it_should_fail_without_a_symbol()
    {
        $logo = new \Digitonic\IexCloudSdk\Stocks\News($this->client);

        $this->expectException(WrongData::class);

        $logo->get();
    }

    /** @test
     * @throws WrongData
     */
    public function it_should_not_allow_less_than_one_item()
    {
        $logo = new \Digitonic\IexCloudSdk\Stocks\News($this->client);

        $this->expectException(WrongData::class);

        $logo->setSymbol('appl')->take(0)->get();
    }

    /** @test
     * @throws WrongData
     */
    public function it_should_not_allow_more_than_50_items()
    {
        $logo = new \Digitonic\IexCloudSdk\Stocks\News($this->client);

        $this->expectException(WrongData::class);

        $logo->setSymbol('appl')->take(51)->get();
    }

    /** @test
     * @throws WrongData
     */
    public function it_can_query_the_news_endpoint()
    {
        $logo = new \Digitonic\IexCloudSdk\Stocks\News($this->client);

        $response = $logo->setSymbol('aapl')->take(10)->get();
        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(10, $response);
    }

    /** @test */
    public function it_can_call_the_facade()
    {
        $this->setConfig();

        News::shouldReceive('setSymbol')
            ->once()
            ->andReturnSelf();

        News::setSymbol('aapl');
    }
}
