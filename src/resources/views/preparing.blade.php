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
                <!-- <table>
                    <tr>
                        @foreach(["", "A", "B", "C", "D", "E", "F", "G", "H", "I", "J"] as $col)
                            <th>{{ $col }}</th>
                        @endforeach
                    </tr>
                    @for($i = 0 ; $i < 10 ; $i++)
                        <tr key="{{ $i }}" id="row-{{ $i }}">
                            <td style="padding-right: 10px; font-weight: bold;">{{ $i }}</td>
                            @for($j = 0 ; $j < 10 ; $j++)
                                <td><div id="{{ $i }}-{{ $j }}" class="section" ondrop="drop(event)" ondragover="allowDrop(event)"></div></td>
                            @endfor
                        </tr>
                    @endfor
                </table> -->
                <map></map>
            </div>
            <div id="right-box" class="col">
                <my-button id="rotate-ships-btn" text="Rotate Ships"></my-button>
            </div>
        </div>
        <hr />
        <h4>Ships:</h4>
        <div id="ship-box">
            @foreach([5, 4, 3, 3, 2] as $size)
                <div id="ship-{{ $loop->index }}-size-{{ $size }}" class="ship rotate-ship" style="width: {{ $size * 38 }}px;" ondragstart="drag(event)" draggable="true"></div>
            @endforeach
        </div>
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

        .action-btn {
            text-decoration: none;
            padding: 20px;
            color: black;
            border: 1px solid black;
            border-radius: 40px;
            font-size: 14pt;
            box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
            transition: all 0.3s cubic-bezier(.25,.8,.25,1);
            cursor: pointer;
            user-select: none;
        }

        .action-btn:hover {
            box-shadow: 0 14px 28px rgba(0,0,0,0.25), 0 10px 10px rgba(0,0,0,0.22);
            text-decoration: none;
            color: black;
        }

        #ship-box {
            height: 200px;
        }

        #ship-box .ship {
            display: inline-block;
            position: relative;
            height: 38px;
            border-radius: 50px;
            background-color: brown;
            margin-left: 5px;
            margin-right: 5px;
            margin-top: 50px;
            transition: transform 0.5s ease-out;
            cursor: move;
        }

        .rotate-ship {
            transform: rotate(90deg);
        }

        #content-box .ship {
            background-color: brown;
            border-radius: 50px;
            width: 114px;
            height: 38px;
        }

        .ship-body-horizontal {
            position: absolute;
            background-color: brown;
            top: 2px;
            left: -1px;
            right: -1px;
            bottom: 2px;
        }

        .ship-body-vertical {
            position: absolute;
            background-color: brown;
            top: -1px;
            left: 2px;
            right: 2px;
            bottom: -1px;
        }

        .ship-end-up {
            position: absolute;
            background-color:brown;
            top: 2px;
            left: 2px;
            right: 2px;
            bottom: -1px;
            border-radius: 50px 50px 0 0;
        }

        .ship-end-down {
            position: absolute;
            background-color:brown;
            top: -1px;
            left: 2px;
            right: 2px;
            bottom: 2px;
            border-radius: 0 0 50px 50px;
        }

        .ship-end-left {
            position: absolute;
            background-color:brown;
            top: 2px;
            left: 2px;
            right: -1px;
            bottom: 2px;
            border-radius: 50px 0 0 50px;
        }

        .ship-end-right {
            position: absolute;
            background-color:brown;
            top: 2px;
            left: -1px;
            right: 2px;
            bottom: 2px;
            border-radius: 0 50px 50px 0;
        }
    </style>
@endsection

@section('page_script')
    <script>
        var shipBox;
        var map = [
            [0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
            [0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
            [0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
            [0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
            [0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
            [0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
            [0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
            [0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
            [0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
            [0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
        ];

        window.onload = function(){
            // hajókat tartalmazó doboz
            shipBox = document.getElementById("ship-box");

            // a játék gomb lenyomásával elküldi a map-et a következő oldalra
            document.getElementById("start-game-btn").addEventListener("click", function(){
                event.preventDefault();
                var data = JSON.stringify(map);
                var form = document.getElementById("start-game-form");
                form.data.value = data;
                console.log(data, typeof data);
                form.submit();
            });

            // hajók forgatása
            document.getElementById("rotate-ships-btn").addEventListener("click", function(){
                for(var ship of document.querySelectorAll("#ship-box .ship")){
                    ship.classList.toggle("rotate-ship");
                }
            });
        }
        
        // hajó megfogása
        function drag(ev) {
            ev.dataTransfer.setData("id", ev.target.id);
            ev.dataTransfer.setData("className", ev.target.className);
        } 

    </script>
@endsection