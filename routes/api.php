<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);

    Route::group(['middleware' => 'jwt.auth'], function() {
        Route::group(['namespace' => 'App\Http\Controllers\Book', 'prefix' => 'books'], function() {
            Route::get('/', 'IndexController');
            Route::get('/{book}', 'ShowController');
        
            Route::post('/store', 'StoreController');
            Route::patch('/{book}', 'UpdateController');
            Route::delete('/{book}', 'DestroyController');
        });
    });
});

Route::group(['namespace' => 'App\Http\Controllers\User'], function() {
    Route::get('/users', 'IndexController');

    Route::post('/users', 'StoreController');
});
