<?php

use App\Modules\User\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1/users')->name('users.')
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::apiResource('', UserController::class)->parameter('', 'user');
    });
