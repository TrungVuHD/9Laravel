<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, Mandrill, and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'facebook' => [
        'client_id' => '1179319355440565',
        'client_secret' => 'f705746b5172ee194e25f76d56f7a231',
        'redirect' => 'http://9laravel.superbrackets.com/facebook/callback'
    ],

    'twitter' => [
        'client_id' => 'DCoV5hqCpB50pGwWw7NnR5TR2',
        'client_secret' => '08teYLi0OFAWJkFjJKhIIvTv4Gg1yaDCOjvxF9ra5DqBKwUcc5',
        'redirect' => 'http://9laravel.superbrackets.com/twitter/callback'
    ],

    'google' => [
        'client_id' => '423839374141-8gb36a614u6tt6vtdektvv1i4cts7r2o.apps.googleusercontent.com',
        'client_secret' => 'ONDg3W_rZYgns39YDMsMWlu7',
        'redirect' => 'http://9laravel.superbrackets.com/google/callback'
    ],
];
