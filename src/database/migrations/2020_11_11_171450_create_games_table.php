<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('player_one_id');
            $table->unsignedBigInteger('player_two_id');
            $table->timestamp('starting_time');
            $table->unsignedBigInteger('played_time');
            $table->unsignedBigInteger('player_one_xp');
            $table->unsignedBigInteger('player_two_xp');
            $table->unsignedBigInteger('winner');
            $table->timestamps();

            $table->index('player_one_id');
            $table->index('player_two_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('games');
    }
}
