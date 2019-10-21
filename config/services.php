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

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'gmaps' => [
        'key' => env('GMAPS_API_KEY'),
    ],
    'google' => [
        'client_id' => env('GOOGLE_APPID'),
        'client_secret' => env('GOOGLE_SECRET'),
        'redirect' => env('GOOGLE_REDIRECT'),
        'account' => 'https://plus.google.com/u/0/',
        'icon' => 'fa fa-google-plus',
    ],
    'facebook' => [
        'client_id' => env('FACEBOOK_APPID'),
        'client_secret' => env('FACEBOOK_SECRET'),
        'redirect' => env('FACEBOOK_REDIRECT'),
        'account' => 'https://www.facebook.com/',
        'icon' => 'fa fa-facebook',
    ],
    'vkontakte' => [
        'account' => 'https://vk.com/id',
        'icon' => 'fa fa-vk',
        'client_id' => env('VKONTAKTE_KEY'),
        'client_secret' => env('VKONTAKTE_SECRET'),
        'redirect' => env('VKONTAKTE_REDIRECT_URI')
    ],

];
