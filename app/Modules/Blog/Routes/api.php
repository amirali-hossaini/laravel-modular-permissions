<?php

use App\Modules\Blog\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1/blog')->name('blog.')
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::apiResource('posts', PostController::class);
    });
