@extends('layouts.app')

@section('content')
    <div class="container text-center">
        <h2>Drag and drop your ships to the sea</h2>
        <div id="content-box" class="row my-5">
            <div id="left-box" class="col">
                <a id="start-game-btn" class="action-btn" href="#">Start Game</a>
            </div>
            <div id="center-box" class="col-6">
                <!-- <table>
                    <tr>
                        <td></td>
                        <td>A</td>
                        <td>B</td>
                        <td>C</td>
                        <td>D</td>
                        <td>E</td>
                        <td>F</td>
                        <td>G</td>
                        <td>H</td>
                        <td>I</td>
                        <td>J</td>
                    </tr>
                    @for($i = 0 ; $i < 10 ; $i++)
                        <tr key="{{ $i }}">
                            <td>{{ $i }}</td>
                            @for($j = 0 ; $j < 10 ; $j++)
                                <td><div id="{{ $i }}-{{ $j }}" class="section"></div></td>
                            @endfor
                        </tr>
                    @endfor
                </table> -->
                <div class="row">
                    <div class="col"></div>
                    <div class="col">A</div>
                    <div class="col">B</div>
                    <div class="col">C</div>
                    <div class="col">D</div>
                    <div class="col">E</div>
                    <div class="col">F</div>
                    <div class="col">G</div>
                    <div class="col">H</div>
                    <div class="col">I</div>
                    <div class="col">J</div>
                </div>
                @for($i = 0 ; $i < 10 ; $i++)
                    <div class="row">
                        <div class="col">{{ $i }}</div>
                        @for($j = 0 ; $j < 10 ; $j++)
                            <div id="{{ $i }}-{{ $j }}" class="col section"></div>
                        @endfor
                    </div>
                @endfor
            </div>
            <div id="right-box" class="col">
                <div id="rotate-ships-btn" class="action-btn">Rotate Ships</div>
            </div>
        </div>
        <hr />
        <h4>Ships:</h4>
        <div id="ship-box">
            @foreach([5, 4, 3, 3, 2] as $size)
                <div id="ship-{{ $loop->index }}-size-{{ $size }}" class="ship rotate-ship" style="width: {{ $size * 38 }}px;" draggable="true"></div>
            @endforeach
        </div>
    </div>
@endsection

@section('page_style')
    <style>
        .section {
            position: relative;
            width: 38px;
            height: 38px;
            border: 1px solid white;
            background-color: lightblue;
        }

        #center-box table {
            margin-left: auto;
            margin-right: auto;
        }

        #left-box, #right-box {
            display: flex;
            align-items: center;
            justify-content: center;
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
            width: 114px;
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

        .ship-body {
            position: absolute;
            background-color: brown;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
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

        console.log(map);

        window.onload = function(){
            shipBox = document.getElementById("ship-box");

            document.getElementById("rotate-ships-btn").addEventListener("click", function(){
                for(var ship of document.querySelectorAll("#ship-box .ship")){
                    ship.classList.toggle("rotate-ship");
                }
            })

            var items = document.getElementsByClassName("ship");
            for(var item of items){
                item.addEventListener("dragstart", drag);
            };

            items = document.getElementsByClassName("section");
            for(var item of items){
                item.addEventListener("drop", drop);
                item.addEventListener("dragover", allowDrop);
            };
        }

        function allowDrop(ev) {
            ev.preventDefault();
        }

        function drag(ev) {
            ev.dataTransfer.setData("id", ev.target.id);
            ev.dataTransfer.setData("className", ev.target.className);
        } 

        function drop(ev) {
            ev.preventDefault();
            var id = ev.dataTransfer.getData("id");
            var size = parseInt(id.split("-").pop());
            var className = ev.dataTransfer.getData("className");
            var isRotated = className.split(" ").includes("rotate-ship");
            var tmp = ev.target.id.split("-");
            var row = parseInt(tmp[0]);
            var col = parseInt(tmp[1]);
            if(map[row][col] == 1) return;
            if(isRotated){
                var step = 1;
                var spaceUp = 0, spaceDown = 0;
                while(true){
                    if(row - step < 0) break;
                    if(map[row-step][col] == 0){
                        ++spaceUp;
                        ++step;
                    }
                    else break;
                }
                step = 1;
                while(true){
                    if(row + step > 9) break;
                    if(map[row+step][col] == 0){
                        ++spaceDown;
                        ++step;
                    }
                    else break;
                }

                var allSpaces = spaceUp + spaceDown + 1;
                if(allSpaces < size){
                    return;
                }

                var stepUp = Math.floor(size / 2);
                var stepDown = size - stepUp - 1;

                if(stepUp > spaceUp){
                    stepUp =spaceUp;
                    stepDown = size - stepUp - 1;
                }
                else if(stepDown > spaceDown){
                    stepDown = spaceDown;
                    stepUp = size - stepDown - 1;
                }

                for(var i = stepUp ; i > 0 ; --i){
                    map[row-i][col] = 1;
                    var newDiv = document.createElement("div");
                    newDiv.className = "ship-body";
                    document.getElementById("" + (row-i) + "-" + col).appendChild(newDiv);
                }

                for(var i = stepDown ; i >= 0 ; --i){
                    map[row+i][col] = 1;
                    var newDiv = document.createElement("div");
                    newDiv.className = "ship-body";
                    document.getElementById("" + (row + i) + "-" + col).appendChild(newDiv);
                }
            }
            else{
                // vizszintes
                var step = 1;
                var spaceLeft = 0, spaceRight = 0;
                while(true){
                    if(col - step < 0) break;
                    if(map[row][col-step] == 0){
                        ++spaceLeft;
                        ++step;
                    }
                    else break;
                }
                step = 1;
                while(true){
                    if(col + step > 9) break;
                    if(map[row][col+step] == 0){
                        ++spaceRight;
                        ++step;
                    }
                    else break;
                }

                var allSpaces = spaceLeft + spaceRight + 1;
                if(allSpaces < size){
                    return;
                }

                var stepRight = Math.floor(size / 2);
                var stepLeft = size - stepRight - 1;

                if(stepLeft > spaceLeft){
                    stepLeft = spaceLeft;
                    stepRight = size - stepLeft - 1;
                }
                else if(stepRight > spaceRight){
                    stepRight = spaceRight;
                    stepLeft = size - stepRight - 1;
                }
                for(var i = stepLeft ; i > 0 ; --i){
                    map[row][col-i] = 1;
                    var newDiv = document.createElement("div");
                    newDiv.className = "ship-body";
                    document.getElementById("" + row + "-" + (col - i)).appendChild(newDiv);
                }
                for(var i = stepRight ; i > 0 ; --i){
                    map[row][col+i] = 1;
                    var newDiv = document.createElement("div");
                    newDiv.className = "ship-body";
                    document.getElementById("" + row + "-" + (col + i)).appendChild(newDiv);
                }
            }
            console.log(map);

            var newDiv = document.createElement("div");
            newDiv.className = "ship-body";
            ev.target.appendChild(newDiv);

            shipBox.removeChild(document.getElementById(id));
        }
    </script>
@endsection