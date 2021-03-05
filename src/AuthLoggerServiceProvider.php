<?php

namespace Spargon\AuthLogger;

use Illuminate\Support\ServiceProvider;
use Spargon\AuthLogger\Commands\AuthLoggerCommand;
use Spargon\AuthLogger\Providers\EventServiceProvider;

class AuthLoggerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/auth-logger.php' => config_path('auth-logger.php'),
            ], 'config');

            $this->publishes([
                __DIR__.'/../resources/views' => base_path('resources/views/vendor/auth-logger'),
            ], 'views');

            $this->publishes([
                __DIR__.'/../resources/lang' => base_path('resources/lang/vendor/auth-logger'),
            ],
                'lang'
            );

            $migrationFileName = 'create_auth_logs_table.php';
            if (! $this->migrationFileExists($migrationFileName)) {
                $this->publishes([
                    __DIR__."/../database/migrations/{$migrationFileName}.stub" => database_path('migrations/'.date('Y_m_d_His', time()).'_'.$migrationFileName),
                ], 'migrations');
            }

            $this->commands([
                AuthLoggerCommand::class,
            ]);
        }

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'auth-logger');

        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'auth-logger');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/auth-logger.php', 'auth-logger');
        $this->app->register(EventServiceProvider::class);
    }

    public static function migrationFileExists(string $migrationFileName): bool
    {
        $len = strlen($migrationFileName);
        foreach (glob(database_path('migrations/*.php')) as $filename) {
            if ((substr($filename, -$len) === $migrationFileName)) {
                return true;
            }
        }

        return false;
    }
}
