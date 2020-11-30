@extends('layouts.app')

@section('content')
    <div class="container text-center">
        <h2>Drag and drop your ships to the sea</h2>
        <div id="content-box" class="row my-5">
            <div id="left-box" class="col">
                <my-button id="start-game-btn" text="Start Game" class="disabled-btn"></my-button>
                @guest
                    <form id="start-game-form" action="{{ route('guest.game') }}" method="POST" class="d-none">
                        @csrf
                        <input name="data" type="hidden" value=""/>
                    </form>
                @else
                    <form id="start-game-form" action="{{ route('singleplayer.game') }}" method="POST" class="d-none">
                        @csrf
                        <input name="data" type="hidden" value=""/>
                    </form>
                @endguest
            </div>
            <div id="center-box" class="col-6">
                <editable-map></editable-map>
            </div>
            <div id="right-box" class="col">
                <my-button id="rotate-ships-btn" text="Rotate Ships" route="#"></my-button>
            </div>
        </div>
        <hr />
        <h4>Ships:</h4>
        <ship-list v-bind:ships="[5, 4, 3, 3, 2]"></ship-list>
    </div>
@endsection

@section('page_style')
    <style>
        #center-box table {
            margin-left: auto;
            margin-right: auto;
        }

        #left-box, #right-box {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .disabled-btn {
            pointer-events: none;
            opacity: 0.5;
        }

        #content-box .ship {
            background-color: brown;
            border-radius: 50px;
            width: 114px;
            height: 38px;
        }
    </style>
@endsection

@section('page_script')
    <script>
        window.onload = function(){
            // hajók forgatása
            document.getElementById("rotate-ships-btn").addEventListener("click", function(event){
                event.preventDefault();
                for(var ship of document.querySelectorAll("#ship-box .ship")){
                    ship.classList.toggle("rotate-ship");
                }
            });
        }
    </script>
@endsection