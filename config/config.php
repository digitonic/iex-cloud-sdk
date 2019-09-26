<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Sandbox Mode
    |--------------------------------------------------------------------------
    |
    | When sandbopx mode is enabled all apis will be performed against the
    | sandbox base url by default. All data returned from this endpoint
    | will be manipulated values and won't contain real data.
    |
    */
    'sandbox' => env('IEX_CLOUD_SANDBOX', false),

    /*
    |--------------------------------------------------------------------------
    | Sandbox Base URL
    |--------------------------------------------------------------------------
    |
    | Specify which Sandbox API should be used when sandbox = true
    |
    */
    'sandbox_base_url' => 'https://sandbox.iexapis.com/v1/',

    /*
    |--------------------------------------------------------------------------
    | Base URL
    |--------------------------------------------------------------------------
    |
    | IEX Cloud will release new versions when they make backwards-incompatible
    | changes to the API. Use the Base URL configuration to determine which
    | version of the API should be used.
    |
    */
    'base_url' => env('IEX_CLOUD_BASE_URL', 'https://cloud.iexapis.com/v1/'),

    /*
    |--------------------------------------------------------------------------
    | Secret API Token
    |--------------------------------------------------------------------------
    |
    | Secret API tokens should be kept confidential and only stored on your
    | own servers. Your account’s secret API token can perform any
    | API request to IEX Cloud.
    |
    */
    'secret_key' => env('IEX_CLOUD_SECRET_KEY'),

    /*
    |--------------------------------------------------------------------------
    | Publishable API Token
    |--------------------------------------------------------------------------
    |
    | Publishable API tokens are meant solely to identify your account with
    | IEX Cloud, they aren’t secret. They can be published in places like
    | your website JavaScript code, or in an iPhone or Android app.
    |
    */
    'public_key' => env('IEX_CLOUD_PUBLIC_KEY')
];
