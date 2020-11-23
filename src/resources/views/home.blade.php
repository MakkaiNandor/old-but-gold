@extends('layouts.app')

@section('content')
    @guest
        <div class="container text-center">
            <p class="mt-5 h4">The Battelship game is the best in the world, try it yourself now as guest or you can registrate!</p>
            <p><img src="./images/logo.png" alt="image"/></p>
            <p><a href="{{ route('singleplayer.preparing') }}" class="btn btn-outlined-primary btn-lg rounded-circle p-4 border-dark PlayAsGuest">Play as guest</a></p>
        </div>
    @else
        <div class="container">
            <div id="user-info" class="row text-center h5">
                <div class="col">{{ "Lvl. " . $user->level }}</div>
                <div class="col font-weight-bold h4">{{ $user->username }}</div>
                <div class="col">{{ "Played games: " . $user->played_games }}</div>
                <div class="col">{{ "Victories: " . $user->victories }}</div>
                <div class="col">{{ "Defeats: " . $user->defeats }}</div>
            </div>
            <div id="buttons" class="text-center">
                <a id="single" class="play-btn card mx-5" href="{{ route('singleplayer.preparing') }}">Singleplayer</a>
                <a id="multi" class="play-btn card mx-5" href="#">Multiplayer</a>
            </div>
            <div>
            {{$map ?? ''}}
            </div>
        </div>
    @endguest
@endsection

@section('page_style')
    <style>
        #user-info {
            border-bottom: 1px solid black;
        }

        #buttons {
            width: max-content;
            margin-left: auto;
            margin-right: auto;
            margin-top: 10%;
        }

        .play-btn {
            display: inline-block;
            text-decoration: none;
            color: black;
            width: 200px;
            height: 300px;
            border: 1px solid black;
            border-radius: 40px;
            line-height: 300px;
            font-size: 18pt;
            box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
            transition: all 0.3s cubic-bezier(.25,.8,.25,1);
            cursor: pointer;
            user-select: none;
        }

        .play-btn:hover {
            box-shadow: 0 14px 28px rgba(0,0,0,0.25), 0 10px 10px rgba(0,0,0,0.22);
            text-decoration: none;
            color: black;
        }

        .PlayAsGuest {
            background-color: rgba(0,0,0,0.05);
            text-decoration: none;  
            font: 40px "Nunito", sans-serif;
            color: grey;
            box-shadow: 0px 0px 20px 20px rgba(0,0,0,0.3);
            border-radius: 50%;
            padding: 17px;
            margin-left: 25px;
            border: none;
        }
    </style>
@endsection

@section('page_script')
    @auth
        <script>
            window.onload = function(){
                document.getElementById("single").addEventListener("click", startSinglePlayer);
                document.getElementById("multi").addEventListener("click", startMultiPlayer);
            }

            function startSinglePlayer(){

            }

            function startMultiPlayer(){
                alert("Coming soon");
            }
        </script>
    @endauth
@endsection