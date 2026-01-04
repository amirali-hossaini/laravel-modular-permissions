<?php

use App\Modules\Authentication\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1/authentication')->name('authentication.')
    ->controller(AuthController::class)
    ->group(function () {
        Route::post('login', 'login')->name('login');
    });
