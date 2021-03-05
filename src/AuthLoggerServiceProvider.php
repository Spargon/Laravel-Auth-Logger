<?php

namespace Spargon\AuthLogger;

use Spargon\AuthLogger\Commands\AuthLoggerCommand;
use Spargon\AuthLogger\Providers\EventServiceProvider;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Spatie\LaravelPackageTools\Package;

class AuthLoggerServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('auth-logger')
            ->hasConfigFile()
            ->hasViews()
            ->hasTranslations()
            ->hasMigration('create_auth_logs_table')
            ->hasCommand(AuthLoggerCommand::class);
    }

    public function packageRegistered()
    {
        $this->app->register(EventServiceProvider::class);
    }
}
