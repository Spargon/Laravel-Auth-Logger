<?php

namespace Spargon\AuthLogger\Providers;

use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Auth\Events\OtherDeviceLogout;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Spargon\AuthLogger\Listeners\LogOtherDevicesLogout;
use Spargon\AuthLogger\Listeners\LogSuccessfulLogin;
use Spargon\AuthLogger\Listeners\LogSuccessfulLogout;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Login::class => [
            LogSuccessfulLogin::class,
        ],

        Logout::class => [
            LogSuccessfulLogout::class,
        ],

        OtherDeviceLogout::class => [
            LogOtherDevicesLogout::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }
}
