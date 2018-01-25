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
    |
    */
    'enabled' => env('SCHEDULER_ENABLED', false),
    'table' => env('SCHEDULER_TABLE', 'scheduler'),
    'url' => env('SCHEDULER_URL', 'scheduler')
];