<?php

use Illuminate\Support\Facades\Route;
use M1guelpf\Web3Login\Http\Controllers\Web3LoginController;

Route::middleware('web')->as('web3')->prefix('_web3')->group(function () {
    Route::get('signature', [Web3LoginController::class, 'signature'])->name('.signature');
    Route::post('link', [Web3LoginController::class, 'link'])->middleware('auth')->name('.link');
    Route::post('login', [Web3LoginController::class, 'login'])->middleware('guest')->name('.login');
});
