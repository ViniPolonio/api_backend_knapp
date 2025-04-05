<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within the group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->prefix('v1')->group(function () {
    Route::apiResource('user', \App\Http\Controllers\UserController::class);
    Route::apiResource('branch', \App\Http\Controllers\BranchController::class);
    Route::apiResource('company', \App\Http\Controllers\CompanyController::class);
});
