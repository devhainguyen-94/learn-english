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
         * Group Action Folder
         */
        Route::get('/get-list-folder', [App\Http\Controllers\Api\FolderController::class, 'getListFolder']);
        Route::post('/create-folder', [App\Http\Controllers\Api\FolderController::class, 'createFolder']);
        Route::put('/update-folder/{id}', [App\Http\Controllers\Api\FolderController::class, 'updateFolder']);
        Route::delete('/delete-folder/{id}', [App\Http\Controllers\Api\FolderController::class, 'deleteFolder']);
        /**
         * Group Action Group Card
         */
        Route::get('/get-list-group-card/{id}', [App\Http\Controllers\Api\CardController::class, 'getListGroupCard']);
        Route::post('/create-group-card', [App\Http\Controllers\Api\CardController::class, 'createGroupCard']);
        Route::put('/update-group-card', [App\Http\Controllers\Api\CardController::class, 'createGroupCard']);
        Route::delete('/delete-group-card', [App\Http\Controllers\Api\CardController::class, 'createGroupCard']);
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
        Route::get('/get-user', [App\Http\Controllers\Api\UserController::class, 'getUser']);
        Route::get('/get-all-class', [App\Http\Controllers\Api\UserController::class, 'getAllClass']);
    });
    /**
     *
     */
    Route::get('/get-list-group-card', [App\Http\Controllers\Api\CardController::class, 'getListGroupCardByUser']);
});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
