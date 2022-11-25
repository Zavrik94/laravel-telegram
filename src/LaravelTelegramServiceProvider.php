<?php

namespace Zavrik\LaravelTelegram;

use Illuminate\Support\ServiceProvider;
use Zavrik\LaravelTelegram\CLI\RegisterBot;

class LaravelTelegramServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the package services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->loadRoutesFrom(__DIR__.'/../routes/routes.php');
        if ($this->app->runningInConsole()) {
            $this->commands([
                RegisterBot::class,
            ]);
        }
    }

    public function register()
    {
        $this->publishes([
            __DIR__.'/../config/telegram.php' => config_path('telegram.php'),
        ]);
    }
}
