@extends('layouts.app')

@section('content')
    <h4 id="turn" class="text-center">Your turn!</h4>
    <div class="row text-center">
        <div class="col">
            <my-map v-bind:map="{{ json_encode($map) }}"></my-map>
        </div>
        <div id="message-block" class="mt-5 mx-5 text-center p-3">
            <h5>Message block</h5>
            <hr/>
            <p><strong>Game start!</strong></p>
        </div>
        <div class="col">
            <enemy-map></enemy-map>
        </div>
    </div>
    <div id="game-over-block" class="d-none">
        <div id="game-over-message" class="p-5 text-center">
            <h4 id="title" class="mb-5"></h4>
            @guest
                <my-button id="rematch-btn" text="Rematch" route="{{ route('guest.preparing') }}"></my-button>
            @else
                <div class="mb-5">
                    <div id="reward">0 XP</div>
                    <div id="user-xp">
                        <span>{{ Auth::user()->level . " lvl." }}</span>
                        <div id="status-bar">
                            <div id="old-xp"></div>
                            <div id="new-xp"></div>
                        </div>
                        <span>{{ (Auth::user()->level + 1) . " lvl." }}</span>
                    </div>
                </div>
                <my-button id="rematch-btn" text="Rematch" route="{{ route('singleplayer.preparing') }}"></my-button>
            @endguest
            <my-button id="home-btn" text="Back to Home" route="{{ route('home') }}"></my-button>
        </div>
    </div>
    <form id="new-game-form" method="POST" action="{{ route('game.save') }}" target="target-iframe">
        @csrf
        <input type="hidden" name="player_one_id"></input>
        <input type="hidden" name="player_two_id"></input>
        <input type="hidden" name="starting_time"></input>
        <input type="hidden" name="played_time"></input>
        <input type="hidden" name="player_one_xp"></input>
        <input type="hidden" name="player_two_xp"></input>
        <input type="hidden" name="winner"></input>
    </form>
    <iframe name="target-iframe" class="d-none"></iframe>
@endsection

@section('page_style')
    <style>
        #status-bar {
            display: inline-block;
            height: 10px;
            width: 60%;
            border-radius: 20px;
            background-color: #c9c9c9;
        }

        #old-xp {
            display: inline-block;
            background-color: blue;
            border-radius: 20px 0 0 20px;
            height: 100%;
            float: left;
        }

        #new-xp {
            display: inline-block;
            background-color: green;
            border-radius: 0 20px 20px 0;
            height: 100%;
            float: left;
        }

        .blocked {
            pointer-events: none;
        }

        .miss {
            pointer-events: none;
            visibility: hidden;
        }

        @keyframes hit {
            0%   {background: lightblue;}
            10%  {background: radial-gradient(circle, rgba(255,0,0,1) 1%, rgba(165,42,42,1) 5%, rgba(173,216,230,1) 10%);}
            20%  {background: radial-gradient(circle, rgba(255,0,0,1) 2%, rgba(165,42,42,1) 15%, rgba(173,216,230,1) 20%);}
            30%  {background: radial-gradient(circle, rgba(255,0,0,1) 3%, rgba(165,42,42,1) 20%, rgba(173,216,230,1) 30%);}
            40%  {background: radial-gradient(circle, rgba(255,0,0,1) 4%, rgba(165,42,42,1) 25%, rgba(173,216,230,1) 40%);}
            50%  {background: radial-gradient(circle, rgba(255,0,0,1) 5%, rgba(165,42,42,1) 30%, rgba(173,216,230,1) 50%);}
            60%  {background: radial-gradient(circle, rgba(255,0,0,1) 6%, rgba(165,42,42,1) 35%, rgba(173,216,230,1) 60%); z-index: 1;}
            70%  {background: radial-gradient(circle, rgba(255,0,0,1) 7%, rgba(165,42,42,1) 40%, rgba(173,216,230,1) 70%); transform: scale(1.25)}
            80%  {background: radial-gradient(circle, rgba(255,0,0,1) 8%, rgba(165,42,42,1) 45%, rgba(173,216,230,1) 80%); transform: scale(1.5)}
            90%  {background: radial-gradient(circle, rgba(255,0,0,1) 7%, rgba(165,42,42,1) 40%, rgba(173,216,230,1) 70%); transform: scale(1.25)}
            100% {background: radial-gradient(circle, rgba(255,0,0,1) 6%, rgba(165,42,42,1) 35%, rgba(173,216,230,1) 60%);}
        }

        .hit {
            pointer-events: none;
            animation-name: hit;
            animation-duration: 0.5s;
            background: radial-gradient(circle, rgba(255,0,0,1) 6%, rgba(165,42,42,1) 35%, rgba(173,216,230,1) 60%);
        }

        #my-map {
            margin-right: 0;
            margin-left: auto;
        }

        #message-block {
            border: 1px solid gray;
            border-radius: 50px;
            width: 250px;
            height: 380px;
            overflow: auto;
        }

        #game-over-block {
            position: absolute;
            top: 0;
            left: 0;
            background: rgba(255, 255, 255, 0.6);
            height: 100vh;
            width: 100%;
        }

        #game-over-message {
            width: 50%;
            margin-right: auto;
            margin-left: auto;
            margin-top: 200px;
            background: white;
            border: 1px solid gray;
            border-radius: 50px;
        }

        #rematch-btn, #home-btn {
            transform: scale(0.8);
        }
    </style>
@endsection

@section('page_script')
    <script src="{{ asset('js/gameplay.js') }}"></script>
    <script>
        var user = JSON.parse("{{ Auth::check() ? Auth::user() : 0 }}".replaceAll("&quot;", "\""));
        var userData = user ? {
            userId: user.id,
            userLvl: user.level,
            userXp: user.experience_points - (user.level - 1) * 1000
        } : null;
        let gameplay = new SingleplayerGameplay({{ json_encode($map) }}, userData);
    </script>
@endsection