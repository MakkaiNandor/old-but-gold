<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DateTime;

class GameController extends Controller
{
    
    /**
     * Redirect to the 'gameplay view' and pass the data to it.
     * 
     * @param Request $request
     * @return object
     * */ 
    public function startGame(Request $request){
        $map = json_decode($request->data);
        return view('game', [
            'map' => $map
        ]);
    }

    /**
     * Create and store a new game in database, update user data.
     * 
     * @param Request $request
     * @return void
     */
    public function saveGame(Request $request){
        $newGame = new Game;
        $newGame->player_one_id = (int) $request->player_one_id;
        $newGame->player_two_id = (int) $request->player_two_id;
        $newGame->starting_time = new DateTime($request->starting_time);
        $newGame->played_time = (int) $request->played_time;
        $newGame->player_one_xp = (int) $request->player_one_xp;
        $newGame->player_two_xp = (int) $request->player_two_xp;
        $newGame->winner = (int) $request->winner;
        $newGame->save();

        $user = Auth::user();
        $user->played_games++;
        if($user->id == $newGame->winner){
            $user->victories++;
        }
        else{
            $user->defeats++;
        }
        if($user->id == $newGame->player_one_id){
            $user->experience_points += $newGame->player_one_xp;
        }
        else{
            $user->experience_points += $newGame->player_two_xp;
        }
        $user->level = floor($user->experience_points / 1000) + 1;
        $user->save();
    }
}
