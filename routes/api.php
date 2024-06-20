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
});


Route::group(['namespace' => 'App\Http\Controllers\Book', 'prefix' => 'books'], function() {
    Route::get('/', IndexController::class);
    Route::get('/{book}', ShowController::class);

    Route::post('/store', StoreController::class);
    Route::patch('/{book}', UpdateController::class);
    Route::delete('/{book}', DestroyController::class);
});

Route::group(['namespace' => 'App\Http\Controllers\User'], function() {
    Route::get('/users', IndexController::class);

    Route::post('/users', StoreController::class);
    
});
