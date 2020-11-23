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

Auth::routes();

Route::redirect('/', '/home');

// kezdőoldal
Route::get('/home', function() {
    return view('home', [
        'user' => Auth::user()
    ]);
})->name('home');

// felhasználó profilja
Route::get('/profile', function(){
    return view('profile', [
        'user' => Auth::user()
    ]);
})->name('profile')->middleware('auth');

// felhasználó statisztikája
Route::get('/statistics', [App\Http\Controllers\UserController::class, 'statistics'])->name('statistics')->middleware('auth');

// felhasználó egyjátékos mód, játék előkészítése
Route::get('/singleplayer/preparing', function(){
    return view('preparing');
})->name('singleplayer.preparing');

// felhasználó egyjátékos mód, játék
Route::post('/singleplayer/game', [App\Http\Controllers\GameController::class, 'startGame'])->name('singleplayer.game');

// vendég, játék előkészítése
Route::get('/guest/preparing', function(){
    return view('preparing');
})->name('guest.preparing');

// vendég, játék
Route::post('/guest/game', [App\Http\Controllers\GameController::class, 'startGame'])->name('guest.game');