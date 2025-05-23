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

Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login']);
Route::post('user-create', [\App\Http\Controllers\UserController::class, 'store']);
Route::get('knapp/view-company', [\App\Http\Controllers\CompanyController::class, 'index']);
Route::get('knapp/view-departament', [\App\Http\Controllers\DepartamentController::class, 'index']);

Route::prefix('knapp')->middleware('auth:sanctum')->group(function () {

    Route::prefix('v1')->group(function () {
        // RESOURCE
        Route::apiResource('departament', \App\Http\Controllers\DepartamentController::class);
        Route::apiResource('user', \App\Http\Controllers\UserController::class);
        Route::apiResource('branch', \App\Http\Controllers\BranchController::class);
        Route::apiResource('company', \App\Http\Controllers\CompanyController::class);

        // GET
        Route::get('user/{idUser}/activate', [\App\Http\Controllers\UserController::class, 'activeUser']);
        Route::get('user/{idUser}/deactivate', [\App\Http\Controllers\UserController::class, 'inactiveUser']);
        Route::get('user/getUsers/{status}/{branchId}', [\App\Http\Controllers\UserController::class, 'getUsers']);
        Route::get('user/getUserByBranch/{branchId}', [\App\Http\Controllers\UserController::class, 'getUsersByBranch']);

        //POST
        
        //PUT
        
        //DELETE
    });
});
