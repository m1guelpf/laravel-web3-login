<?php

namespace M1guelpf\Web3Login;

class Web3Login
{
    /**
     * Indicates if this package's migrations will be run.
     *
     * @var bool
     */
    public static $runsMigrations = true;

    /**
     * Indicates if this package's routes will be registered.
     *
     * @var bool
     */
    public static $registersRoutes = true;

    /**
     * The callback that is responsible for retrieving the user by their wallet.
     *
     * @var callable|null
     */
    public static $retrieveUserCallback;

    /**
     * Register a callback that is responsible for retrieving the user authenticated by Apple.
     *
     * @param  callable  $callback
     * @return void
     */
    public static function retrieveUserWith(callable $callback)
    {
        static::$retrieveUserCallback = $callback;
    }

    /**
     * Configure this package to not register its migrations.
     *
     * @return void
     */
    public static function ignoreMigrations()
    {
        static::$runsMigrations = false;
    }

    /**
     * Configure this package to not register its routes.
     *
     * @return void
     */
    public static function ignoreRoutes()
    {
        static::$registersRoutes = false;
    }
}
