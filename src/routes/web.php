<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('home');
});

Route::get('/PlayAsGuest', function () {
    return view('PlayAsGuest');
})->name('PlayAsGuest');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/profile', [App\Http\Controllers\UserController::class, 'getUser'])->name('profile.index')->middleware('auth');

Route::get('/statistics', [App\Http\Controllers\UserController::class, 'getUserPlayings'])->name('statistics.index')->middleware('auth');