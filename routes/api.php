<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::middleware(['auth:sanctum'])->group(function () {
    Route::middleware(['admin'])->group(function () {
        /**
         * Create User
         */
        Route::post('/create-user', [App\Http\Controllers\Api\UserController::class, 'createUser']);
        /**
         * Class action
         */
        Route::post('/create-class', [App\Http\Controllers\Api\UserController::class, 'createClass']);
        Route::put('/update-class/{id}', [App\Http\Controllers\Api\UserController::class, 'updateClass']);
        Route::delete('/delete-class/{id}', [App\Http\Controllers\Api\UserController::class, 'destroy']);
    });
});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
