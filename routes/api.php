<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AdminAuthController;
use App\Http\Controllers\API\OrganizationController;

Route::prefix('admin')->group(function () {
    Route::post('/login', [AdminAuthController::class, 'login']);
    Route::middleware('auth:sanctum')->post('/logout', [AdminAuthController::class, 'logout']);

    Route::prefix('v1')->group(function () {
        Route::apiResource('organizations', OrganizationController::class);
    });

});


