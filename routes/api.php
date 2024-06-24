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
        Route::group(['namespace' => 'App\Http\Controllers\User', 'prefix' => 'users'], function() {
            Route::get('/id', 'UserIdController');
        });

        Route::group(['namespace' => 'App\Http\Controllers\User', 'prefix' => 'users', 'middleware' => 'admin'], function() {
            Route::get('/', 'IndexController');
            Route::patch('/{user}', 'UpdateController');
            Route::delete('/{user}', 'DestroyController');
        });

        Route::group(['namespace' => 'App\Http\Controllers\Book', 'prefix' => 'books'], function() {
        Route::get('/', 'IndexController');
        Route::get('/{book}', 'ShowController');
    });

        Route::group(['namespace' => 'App\Http\Controllers\Book', 'prefix' => 'books', 'middleware' => 'user'], function() {
            Route::patch('/{book}/reservation', 'ReservationController');
            Route::patch('/{book}/unreservation', 'UnReservationController');
        });

        Route::group(['namespace' => 'App\Http\Controllers\Book', 'prefix' => 'books', 'middleware' => 'librarian'], function() {
            Route::get('/reservated/{book}', 'ReservatedBooksController');
            Route::post('/store', 'StoreController');
            Route::post('/{book}', 'UpdateController');
            Route::delete('/{book}', 'DestroyController');
            Route::patch('/{book}/lend', 'LendController');
            Route::patch('/{book}/pick', 'PickController');
        });
    });
});

Route::group(['namespace' => 'App\Http\Controllers\User'], function() {
    Route::post('/users', 'StoreController');
});
