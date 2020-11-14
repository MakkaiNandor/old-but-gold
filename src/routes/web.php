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

Route::get('/guest', function () {
    return view('PlayAsGuest');
})->name('PlayAsGuest')->middleware('guest');

Auth::routes();

Route::get('/home', function() {
    return view('home', [
        'user' => Auth::user()
    ]);
})->name('home');

Route::get('/profile', function(){
    return view('profile', [
        'user' => Auth::user()
    ]);
})->name('profile')->middleware('auth');

Route::get('/statistics', function(){
    dd(Auth::user()->playings);
    return view('home', [
        'playings' => Auth::user()->playings
    ]);
})->name('statistics')->middleware('auth');

Route::post('/profile/update', [App\Http\Controllers\UserController::class, 'update'])->name('profile.update')->middleware('auth');