<?php

namespace M1guelpf\Web3Login;

use Illuminate\Support\ServiceProvider;

class Web3LoginServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if (Web3Login::$registersRoutes) {
            $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        }

        if (Web3Login::$runsMigrations) {
            $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        }

        $this->publishes([
            __DIR__.'/../config/web3.php' => config_path('web3.php'),
        ], 'config');

        $this->mergeConfigFrom(
            __DIR__.'/../config/web3.php', 'web3'
        );
    }
}
