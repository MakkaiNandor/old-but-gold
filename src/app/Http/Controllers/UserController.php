<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Collection;

class UserController extends Controller
{
    function statistics(){
        $playings = Auth::user()->playings;
        $games = new Collection;
    
        foreach($playings as $playing){
            $games->push($playing->game);
        }
    
        return view('statistics', [
            'playings' => $playings,
            'games' => $games
        ]);
    }
}
