<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;

class GameController extends Controller
{

    public function startGame(Request $request){
        $map = json_decode($request->data);
        return view('game', [
            'map' => $map
        ]);
    }
}
