<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'msegat' => [
        'username' => env('MSEGAT_USERNAME'),
        'api_key' => env('MSEGAT_API_KEY'),
        'sender' => env('MSEGAT_SENDER', 'Bookify'),
        'base_url' => env('MSEGAT_BASE_URL', 'https://www.msegat.com/gw'),
    ],

    'google_maps' => [
        'key' => env('GOOGLE_MAPS_API_KEY'),
    ],

    'paymob' => [
        'base_url' => env('PAYMOB_BASE_URL', 'https://ksa.paymob.com'),
        'api_key' => env('PAYMOB_API_KEY'),
        'secret_key' => env('PAYMOB_SECRET_KEY'),
        'public_key' => env('PAYMOB_PUBLIC_KEY'),
        'integration_id' => env('PAYMOB_INTEGRATION_ID'),
        'apple_pay_integration_id' => env('PAYMOB_APPLE_PAY_INTEGRATION_ID'),
        'moto_integration_id' => env('PAYMOB_MOTO_INTEGRATION_ID'),
        'hmac_secret' => env('PAYMOB_HMAC_SECRET'),
        'paymob_currency' => env('PAYMOB_CURRENCY'),
        'paymob_mode' => env('PAYMOB_MODE'),
    ],

];