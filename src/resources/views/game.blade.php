@extends('layouts.app')

@section('content')
    <h4 class="text-center">Your turn</h4>
    <div class="row text-center">
        <div class="col">
            <table id="my-map">
                <tr>
                    @foreach(["", "A", "B", "C", "D", "E", "F", "G", "H", "I", "J"] as $col)
                        <th>{{ $col }}</th>
                    @endforeach
                </tr>
                @for($i = 0 ; $i < 10 ; $i++)
                    <tr key="{{ $i }}" id="my-row-{{ $i }}">
                        <td style="padding-right: 10px; font-weight: bold;">{{ $i }}</td>
                        @for($j = 0 ; $j < 10 ; $j++)
                            <td><div id="my-{{ $i }}-{{ $j }}" class="section">
                                @switch($map[$i][$j])
                                    @case(1)
                                        <div class="ship-end-up"></div>
                                        @break
                                    @case(-1)
                                        <div class="ship-end-left"></div>
                                        @break
                                    @case(2)
                                        <div class="ship-end-down"></div>
                                        @break
                                    @case(-2)
                                        <div class="ship-end-right"></div>
                                        @break
                                    @case(3)
                                        <div class="ship-body-vertical"></div>
                                        @break
                                    @case(-3)
                                        <div class="ship-body-horizontal"></div>
                                        @break
                                    @default
                                        @break
                                @endswitch
                            </div></td>
                        @endfor
                    </tr>
                @endfor
            </table>
        </div>
        <div id="message-block" class="mt-5 mx-5 text-center p-3">
            <h5>Message block</h5>
            <hr/>
        </div>
        <div class="col">
            <table id="enemy-map">
                <tr>
                    @foreach(["", "A", "B", "C", "D", "E", "F", "G", "H", "I", "J"] as $col)
                        <th>{{ $col }}</th>
                    @endforeach
                </tr>
                @for($i = 0 ; $i < 10 ; $i++)
                    <tr key="{{ $i }}" id="enemy-row-{{ $i }}">
                        <td style="padding-right: 10px; font-weight: bold;">{{ $i }}</td>
                        @for($j = 0 ; $j < 10 ; $j++)
                            <td><div id="enemy-{{ $i }}-{{ $j }}" class="section shootable" onclick="sectionClicked(event)"></div></td>
                        @endfor
                    </tr>
                @endfor
            </table>
        </div>
    </div>
@endsection

@section('page_style')
    <style>
        .section {
            position: relative;
            width: 38px;
            height: 38px;
            background-color: lightblue;
        }

        .blocked {
            pointer-events: none;
        }

        .shootable {
            transition: all 0.5s cubic-bezier(.25,.8,.25,1);
            cursor: pointer;
        }

        .shootable:hover {
            transform: scale(1.2);
            filter: brightness(0.8);
            z-index: 1;
        }

        .miss {
            pointer-events: none;
            visibility: hidden;
            /* filter: brightness(0.8); */
        }

        @keyframes hit {
            0%   {background: lightblue;}
            10%  {background: radial-gradient(circle, rgba(255,0,0,1) 1%, rgba(165,42,42,1) 5%, rgba(173,216,230,1) 10%);}
            20%  {background: radial-gradient(circle, rgba(255,0,0,1) 2%, rgba(165,42,42,1) 15%, rgba(173,216,230,1) 20%);}
            30%  {background: radial-gradient(circle, rgba(255,0,0,1) 3%, rgba(165,42,42,1) 20%, rgba(173,216,230,1) 30%);}
            40%  {background: radial-gradient(circle, rgba(255,0,0,1) 4%, rgba(165,42,42,1) 25%, rgba(173,216,230,1) 40%);}
            50%  {background: radial-gradient(circle, rgba(255,0,0,1) 5%, rgba(165,42,42,1) 30%, rgba(173,216,230,1) 50%);}
            60%  {background: radial-gradient(circle, rgba(255,0,0,1) 6%, rgba(165,42,42,1) 35%, rgba(173,216,230,1) 60%);}
            70%  {background: radial-gradient(circle, rgba(255,0,0,1) 7%, rgba(165,42,42,1) 40%, rgba(173,216,230,1) 70%); transform: scale(1.25)}
            80%  {background: radial-gradient(circle, rgba(255,0,0,1) 8%, rgba(165,42,42,1) 45%, rgba(173,216,230,1) 80%); transform: scale(1.5)}
            90%  {background: radial-gradient(circle, rgba(255,0,0,1) 7%, rgba(165,42,42,1) 40%, rgba(173,216,230,1) 70%); transform: scale(1.25)}
            100% {background: radial-gradient(circle, rgba(255,0,0,1) 6%, rgba(165,42,42,1) 35%, rgba(173,216,230,1) 60%);}
        }

        .hit {
            z-index: 1;
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
            width: 200px;
            overflow: auto;
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
        var ships = [5, 4, 3, 3, 2];    // kigenerálandó hajók
        var myMap = {{ json_encode($map) }};    // saját map
        var enemyMap = [
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
        var messageBlock, enemyMapContainer;

        window.onload = function(){
            generateEnemyShips();
            console.log(enemyMap);
            messageBlock = document.getElementById('message-block');
            enemyMapContainer = document.getElementById("enemy-map");
        }

        function sectionClicked(event){
            enemyMapContainer.classList.toggle("blocked");
            console.log(event.target.id);
            var coords = event.target.id.split("-");
            var row = parseInt(coords[1]);
            var col = parseInt(coords[2]);
            event.target.classList.toggle("shootable");
            if(enemyMap[row][col] == 0){
                event.target.classList.toggle("miss");
                enemyMapContainer.classList.toggle("blocked");
            }
            else{
                event.target.classList.toggle("hit");
                setTimeout(() => {
                    enemyMapContainer.classList.toggle("blocked");
                }, 500);
            }
        }

        // ellenfél hajóinak generálása, elhelyezése
        function generateEnemyShips(){
            for(var shipSize of ships){
                var orientation = Math.floor(Math.random() * 10);   // vízszintes vagy függőleges
                var row, col;   // koordináták
                do{
                    row = Math.floor(Math.random() * 10);
                    col = Math.floor(Math.random() * 10);
                } while(enemyMap[row][col] != 0);
                if(orientation % 2 == 0){ // függőleges hajó generálása
                    var step = 1;
                    var spaceUp = 0, spaceDown = 0;
                    while(true){
                        if(row - step < 0) break;
                        if(enemyMap[row-step][col] == 0){
                            ++spaceUp;
                            ++step;
                        }
                        else break;
                    }
                    step = 1;
                    while(true){
                        if(row + step > 9) break;
                        if(enemyMap[row+step][col] == 0){
                            ++spaceDown;
                            ++step;
                        }
                        else break;
                    }
                    var allSpaces = spaceUp + spaceDown + 1;
                    if(shipSize > allSpaces) {
                        ships.push(shipSize);   
                        continue;
                    }

                    var stepUp = Math.floor(shipSize / 2);  // hajóelemek száma felfele
                    var stepDown = shipSize - stepUp - 1;   // hajóelemek száma lefele

                    // hajó elosztása a szabad helyeken
                    if(stepUp > spaceUp){
                        stepUp = spaceUp;
                        stepDown = shipSize - stepUp - 1;
                    }
                    else if(stepDown > spaceDown){
                        stepDown = spaceDown;
                        stepUp = shipSize - stepDown - 1;
                    }

                    for(var i = row - stepUp; i <= row + stepDown ; ++i){
                        enemyMap[i][col] = 1;
                    }
                }
                else{   // vízszintes hajó generálása
                    var step = 1;
                    var spaceLeft = 0, spaceRight = 0;
                    while(true){
                        if(col - step < 0) break;
                        if(enemyMap[row][col-step] == 0){
                            ++spaceLeft;
                            ++step;
                        }
                        else break;
                    }
                    step = 1;
                    while(true){
                        if(col + step > 9) break;
                        if(enemyMap[row][col+step] == 0){
                            ++spaceRight;
                            ++step;
                        }
                        else break;
                    }
                    var allSpaces = spaceLeft + spaceRight + 1;
                    if(shipSize > allSpaces){
                        ships.push(shipSize);   
                        continue;
                    }

                    var stepLeft = Math.floor(shipSize / 2);  // hajóelemek száma felfele
                    var stepRight = shipSize - stepLeft - 1;   // hajóelemek száma lefele

                    // hajó elosztása a szabad helyeken
                    if(stepLeft > spaceLeft){
                        stepLeft = spaceLeft;
                        stepRight = shipSize - stepLeft - 1;
                    }
                    else if(stepRight > spaceRight){
                        stepRight = spaceRight;
                        stepLeft = shipSize - stepRight - 1;
                    }

                    for(var i = col - stepLeft; i <= col + stepRight ; ++i){
                        enemyMap[row][i] = 1;
                    }
                }
            }
        }
    </script>
@endsection