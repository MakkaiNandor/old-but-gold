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
    $playings = Auth::user()->playings;
    $games = new Illuminate\Database\Eloquent\Collection;

    foreach($playings as $playing){
        $games->push($playing->game);
    }

    return view('statistics', [
        'playings' => $playings,
        'games' => $games
    ]);
})->name('statistics')->middleware('auth');

Route::get('/singleplayer/preparing', function(){
    return view('preparing');
})->name('singleplayer.preparing');