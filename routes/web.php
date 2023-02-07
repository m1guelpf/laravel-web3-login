<?php

use Illuminate\Support\Facades\Route;
use M1guelpf\Web3Login\Http\Controllers\Web3LoginController;

Route::middleware('web')->as('web3')->prefix('_web3')->group(function () {
    $routes = config('web3.routes', ['signature', 'link', 'login']);

    if (in_array('signature', $routes)) {
        Route::get('signature', [Web3LoginController::class, 'signature'])->name('.signature');
    }

    if (in_array('link', $routes)) {
        Route::post('link', [Web3LoginController::class, 'link'])->middleware('auth')->name('.link');
    }

    if (in_array('login', $routes)) {
        Route::post('login', [Web3LoginController::class, 'login'])->middleware('guest')->name('.login');
    }

    if (in_array('register', $routes)) {
        Route::post('register', [Web3LoginController::class, 'register'])->name('.register');
    }
});
