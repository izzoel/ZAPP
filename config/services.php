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
        'token' => env('POSTMARK_TOKEN'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
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

    'keycloak' => [
        'base_url' => env('KEYCLOAK_BASE_URL'),
        'realms' => env('KEYCLOAK_REALM'),
        'client_id' => env('KEYCLOAK_CLIENT_ID'),
        'client_secret' => env('KEYCLOAK_CLIENT_SECRET'),
        'redirect' => env('KEYCLOAK_REDIRECT_URI', 'http://zapp.test/auth/callback'),
    ],


    // 'keycloak' => [
    //     'base_url'      => env('KEYCLOAK_BASE_URL', 'http://127.0.0.1:8080'),
    //     'realms'        => env('KEYCLOAK_REALM', 'master'), // ← ini penting (jamak)
    //     'client_id'     => env('KEYCLOAK_CLIENT_ID', 'zapp.test'),
    //     'client_secret' => env('KEYCLOAK_CLIENT_SECRET', null),
    //     'redirect'      => env('KEYCLOAK_REDIRECT_URI', 'http://127.0.0.1:8080/auth/keycloak/callback'),
    // ],


];
