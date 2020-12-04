<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

class Game extends Model
{
    use HasFactory;

    /**
     * Get player one of the game.
     * 
     * @return object
     */
    public function playerOne(){
        return $this->belongsTo(User::class, 'player_one_id');
    }
    
    /**
     * Get player two of the game.
     * 
     * @return object
     */
    public function playerTwo(){
        return $this->belongsTo(User::class, 'player_two_id');
    }

    /**
     * Get both players of the game.
     * 
     * @return Collection
     */
    public function players(){
        $players = new Collection;
        $players->push($this->playerOne);
        $players->push($this->playerTwo);
        return $players;
    }
}
