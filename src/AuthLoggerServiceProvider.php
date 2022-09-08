<?php

namespace Spargon\AuthLogger;

use Spargon\AuthLogger\Commands\AuthLoggerCommand;
use Spargon\AuthLogger\Providers\EventServiceProvider;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

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
            ->hasCommand(AuthLoggerCommand::class)
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->startWith(function (InstallCommand $command) {
                        $command->info('Setting up the Laravel Auth Logger package by Spargon!');
                    })
                    ->publishConfigFile()
                    ->publishMigrations()
                    ->askToRunMigrations()
                    ->askToStarRepoOnGitHub('spargon/laravel-auth-logger')
                    ->endWith(function (InstallCommand $command) {
                        $command->info('Have a great day fellow tinkerers!');
                    });
            });
    }

    public function packageRegistered()
    {
        $this->app->register(EventServiceProvider::class);
    }
}
