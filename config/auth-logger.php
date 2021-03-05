<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Notification for New Device
    |--------------------------------------------------------------------------
    |
    | Define whether or not notifications should be sent whenever the user
    | logs in from a new device.
    |
    */

    'notify' => env('AUTH_LOGGER_NOTIFY', true),

    /*
    |--------------------------------------------------------------------------
    | Set the Auth Logger table name
    |--------------------------------------------------------------------------
    |
    | When using the Auth Logger package, you can specify which table to be
    | used for storing the auth logs.
    |
    */

    'table_name' => 'auth_logs',

    /*
    |--------------------------------------------------------------------------
    | Clearing Old Logs
    |--------------------------------------------------------------------------
    |
    | When the auth-logger-clear is executed, all authentication logs older than
    | the number of days specified here will be deleted from the database.
    |
    | We recommend deleting any logs older than 31 days for optmized results.
    |
    */

    'older' => env('AUTH_LOGGER_OLDER_THAN', 31),
];
