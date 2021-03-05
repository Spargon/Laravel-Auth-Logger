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

    /*
    |--------------------------------------------------------------------------
    | Customizing Slack Messages
    |--------------------------------------------------------------------------
    |
    | Follow the instructions here for the slack pre-requisites - 
    | https://laravel.com/docs/8.x/notifications#slack-prerequisites
    |
    | Generate your slack incoming webhook from here - 
    | https://slack.com/services/new/incoming-webhook
    |
    | You can customize the Notification Sender name, Channel to receive 
    | notification on and the image icon to show.
    |
    | Custom channel option below will only work if the webhook doesnt have 
    | a fixed channel assigned to it.
    |
    */

    'slack' => [
        'from' => env('APP_NAME', 'Auth Logger'),
        'channel' => '#general', // when changing the channel name, be sure to prefix it with #
        'image' => 'https://laravel.com/img/favicon/favicon-32x32.png', // Replace this with the link to your .png icon
    ],
];
