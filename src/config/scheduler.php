<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Scheduler - service for managing your scheduled tasks
    |--------------------------------------------------------------------------
    |
    | enabled - bool, enable or disable service
    | table - name for database table used by service
    | url - url for service managing page
    | name - url for naming routes
    |
    */

    'enabled' => env('SCHEDULER_ENABLED', false),
    'table' => env('SCHEDULER_TABLE', 'scheduler'),
    'url' => env('SCHEDULER_URL', 'scheduler'),
    'name' => str_replace('/', '.', env('SCHEDULER_URL', 'scheduler')),
    'middleware' => ['auth'],

    'nav-button' => [
        'href' => '/',
        'text' => '< HOME',
    ],

    'expressions' => [
        '* * * * *'      => 'Every minute',
        '*/5 * * * *'    => 'Every 5 minutes',
        '*/10 * * * *'   => 'Every 10 minutes',
        '*/15 * * * *'   => 'Every 15 minutes',
        '*/30 * * * *'   => 'Every 30 minutes',
        '0 * * * *'      => 'Every hour',
        '0 0 * * *'      => 'One per day',
        '0 0 * * 0'      => 'One per week',
        '0 0 1 * *'      => 'One per month',
        '0 0 1 1-12/3 *' => 'One per 2 months',
        '0 0 1 1 *'      => 'One per year',
    ],
];
