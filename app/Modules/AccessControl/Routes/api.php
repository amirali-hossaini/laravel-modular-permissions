<?php

use App\Modules\AccessControl\Http\Controllers\OrganizationalChartController;
use App\Modules\AccessControl\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1/access-control')->name('accessControl.')
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::apiResource('roles', RoleController::class);
        Route::apiResource('organizational-charts', OrganizationalChartController::class);
    });
