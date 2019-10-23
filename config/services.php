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
        'title' => '<i class="fa fa-google-plus left"></i> Google',
        'enabled' => 1,
        'registration' => 1,
    ],
    'facebook' => [
        //https://developers.facebook.com/apps/
        'client_id' => env('FACEBOOK_APPID'),
        'client_secret' => env('FACEBOOK_SECRET'),
        'redirect' => env('FACEBOOK_REDIRECT'),
        'account' => 'https://www.facebook.com/',
        'title' => '<i class="fa fa-facebook left"></i> Facebook',
        'enabled' => 1,
        'registration' => 1,
    ],
    'vkontakte' => [
        'account' => 'https://vk.com/id',
        'client_id' => env('VKONTAKTE_KEY'),
        'client_secret' => env('VKONTAKTE_SECRET'),
        'redirect' => env('VKONTAKTE_REDIRECT_URI'),
        'title' => '<i class="fa fa-vk left"></i> VK',
        'enabled' => 1,
        'registration' => 1,
    ],
    'odnoklassniki' => [
        //https://ok.ru/app/<client_id>
        'client_id' => env('ODNOKLASSNIKI_ID'),
        'client_secret' => env('ODNOKLASSNIKI_SECRET'),
        'client_public' => env('ODNOKLASSNIKI_PUBLIC'),
        'redirect' => env('ODNOKLASSNIKI_REDIRECT'),
        'title' => '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" width="16" height="16" fill="#000000">
  <path d="M 7.5 1 C 5.578125 1 4 2.578125 4 4.5 C 4 6.421875 5.578125 8 7.5 8 C 9.421875 8 11 6.421875 11 4.5 C 11 2.578125 9.421875 1 7.5 1 Z M 7.5 3 C 8.339844 3 9 3.660156 9 4.5 C 9 5.339844 8.339844 6 7.5 6 C 6.660156 6 6 5.339844 6 4.5 C 6 3.660156 6.660156 3 7.5 3 Z M 4.976563 8.378906 C 4.515625 8.382813 4.117188 8.703125 4.011719 9.15625 C 3.910156 9.605469 4.128906 10.066406 4.539063 10.273438 C 4.878906 10.449219 5.242188 10.585938 5.617188 10.703125 L 4.234375 12.359375 C 3.992188 12.632813 3.921875 13.015625 4.042969 13.355469 C 4.164063 13.699219 4.460938 13.945313 4.820313 14.007813 C 5.179688 14.066406 5.542969 13.925781 5.765625 13.640625 L 7.5 11.5625 L 9.234375 13.640625 C 9.457031 13.925781 9.820313 14.066406 10.179688 14.007813 C 10.539063 13.945313 10.835938 13.699219 10.957031 13.355469 C 11.078125 13.015625 11.007813 12.632813 10.765625 12.359375 L 9.382813 10.703125 C 9.757813 10.585938 10.121094 10.449219 10.457031 10.273438 C 10.949219 10.019531 11.140625 9.417969 10.886719 8.925781 C 10.636719 8.433594 10.03125 8.242188 9.539063 8.496094 C 8.917969 8.816406 8.234375 9 7.5 9 C 6.765625 9 6.082031 8.816406 5.460938 8.496094 C 5.3125 8.417969 5.144531 8.375 4.976563 8.378906 Z"/>
</svg> OK',
        'enabled' => 1,
        'registration' => 1,
    ],
    'github' => [
        'client_id' => env('GITHUB_CLIENT_ID'),
        'client_secret' => env('GITHUB_CLIENT_SECRET'),
        'redirect' => env('GITHUB_REDIRECT'),
        'title' => '<i class="fa fa-github left"></i> GitHub',
        'enabled' => 1,
        'registration' => 1,
    ],
    'instagram' => [
        'client_id' => env('INSTAGRAM_CLIENT_ID'),
        'client_secret' => env('INSTAGRAM_CLIENT_SECRET'),
        'redirect' => env('INSTAGRAM_REDIRECT'),
        'title' => '<i class="fa fa-instagram left"></i> Instagram',
        'enabled' => 1,
        'registration' => 1,
    ],

];
