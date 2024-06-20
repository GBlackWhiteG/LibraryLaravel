<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;

Auth::routes();

Route::get('/', function () {
    return redirect('/books');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'home'])->name('home');
Route::get('/{book}', IndexController::class)->where('page', '.*');
