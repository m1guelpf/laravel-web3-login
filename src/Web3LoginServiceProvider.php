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
    }
}
