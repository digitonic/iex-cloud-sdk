# IEX Cloud SDK

[![Latest Version on Packagist](https://img.shields.io/packagist/v/digitonic/iex-cloud-sdk.svg?style=flat-square)](https://packagist.org/packages/digitonic/iex-cloud-sdk)
[![Build Status](https://travis-ci.com/digitonic/iex-cloud-sdk.svg?branch=master)](https://travis-ci.com/digitonic/iex-cloud-sdk)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/digitonic/iex-cloud-sdk/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/digitonic/iex-cloud-sdk/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/digitonic/iex-cloud-sdk/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/digitonic/iex-cloud-sdk/?branch=master)
[![Total Downloads](https://img.shields.io/packagist/dt/digitonic/iex-cloud-sdk.svg?style=flat-square)](https://packagist.org/packages/digitonic/iex-cloud-sdk)

A PHP package for accessing the IEX Cloud API. It focuses heavily on the Laravel Framework however it will work in any standalone project with usage of Composer.

## Installation

You can install the package via composer:

```bash
    composer require digitonic/iex-cloud-sdk
```

## Usage

Please see [Getting Started](GETTING_STARTED.md) for details.

## Development Status

#### Active Development

Below is a list of endpoints to be implemented. (32/97)

### Account

- [x] Metadata
- [x] Usage
- [ ] Pay as you go toggle
- [ ] Message Cutoff

### Data Apis

- [x] Data Points
- [x] Time Series Inventory
- [x] Time Series Query

### Alternative Data

- [x] Social Sentiment
- [x] CEO Compensation
- [x] Crypto Book
- [ ] ~~Crypto Events~~ (Streaming Only)
- [x] Crypto Price
- [x] Crypto Quote

### API System Metadata

- [x] Status

### Forex / Currencies

- [x] Exchange Rates

### Investors Exchange Data

- [x] TOPS
- [x] TOPS last
- [x] DEEP
- [x] DEEP Auction
- [x] DEEP Book
- [x] DEEP Operational Halt Status
- [x] DEEP Official Price
- [x] DEEP Security Event
- [x] DEEP Short Sale Price Test Status
- [x] DEEP System Event
- [x] DEEP Trades
- [x] DEEP Trade Break
- [x] DEEP Trading Status
- [ ] Listed Regulation SHO Threshold Securities List
- [ ] Listed Short Interest List
- [ ] Stats Historical Daily
- [ ] Stats Historical Summary
- [x] Stats Intraday
- [x] Stats Recent
- [x] Stats Records

### Reference Data

- [x] Symbols
- [x] Crypto Symbols
- [x] Search
- [x] IEX Symbols
- [ ] International Symbols (Region)
- [ ] International Symbols (exchange)
- [ ] International Exchanges
- [ ] U.S. Exchanges
- [ ] U.S. Holidays and Trading Days
- [ ] Sectors
- [ ] Tags
- [ ] ISIN Mapping
- [ ] Mutual Fund Symbols
- [ ] OTC Symbols
- [ ] FX Symbols
- [ ] Options Symbols

### Stocks

- [ ] Advanced Stats
- [ ] Balance Sheet
- [ ] Batch Requests
- [ ] Book
- [ ] Cash Flow
- [ ] Collections
- [ ] Company
- [ ] Delayed Quote
- [ ] Dividends
- [ ] Earnings
- [ ] Earnings Today
- [ ] Estimates
- [ ] Financials
- [ ] Fund Ownership
- [ ] Historical Prices
- [ ] Income Statement
- [ ] Insider Roster
- [ ] Insider Summary
- [ ] Insider Transactions
- [ ] Intraday Prices
- [ ] Institutional Ownership
- [ ] IPO Calendar (upcoming)
- [ ] IPO Calendar (today)
- [ ] Key Stats
- [ ] Largest Trades
- [ ] List
- [ ] Logo
- [ ] Market Volume
- [ ] News
- [ ] OHLC
- [ ] Options (exp dates)
- [ ] Options (data)
- [ ] Peers
- [ ] Previous Day Prices
- [ ] Price
- [ ] Price Target
- [ ] Quote
- [ ] Recommendation Trends
- [ ] Sector Performance
- [ ] Splits
- [ ] Upcoming Events (All)
- [ ] Upcoming Events (earnings)
- [ ] Upcoming Events (dividends)
- [ ] Upcoming Events (splits)
- [ ] Upcoming Events (ipos)
- [ ] Volume by Venue

### Testing

``` bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email steven@digitonic.co.uk instead of using the issue tracker.

## Credits

- [Steven Richardson](https://github.com/richdynamix)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
