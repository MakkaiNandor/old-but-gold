@extends('layouts.app')

@section('content')
    <h4 id="turn" class="text-center">Your turn!</h4>
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
            <p>Game start!</p>
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
    <div id="game-over-block" class="d-none">
        <div id="game-over-message" class="p-5 text-center">
            <h4 id="title" class="mb-5"></h4>
            @guest
                <a id="rematch-btn" class="btn" href="{{ route('guest.preparing') }}">Rematch</a>
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
                <a id="rematch-btn" class="btn" href="{{ route('singleplayer.preparing') }}">Rematch</a>
            @endguest
            <a id="home-btn" class="btn ml-4" href="{{ route('home') }}">Back to Home</a>
        </div>
    </div>
@endsection

@section('page_style')
    <style>

        /* @keyframes move {
            0% { scale: 0; }
            100% { scale: 1; }
        } */

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
            /* animation: move 2s cubic-bezier(0, 0.51, 0.73, 0.74); */
            /* width: 60%; */
        }

        #new-xp {
            display: inline-block;
            background-color: green;
            border-radius: 0 20px 20px 0;
            height: 100%;
            float: left;
            /* animation: move 2s cubic-bezier(0, 0.51, 0.73, 0.74); */
            /* width: 24%; */
        }

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

        .btn {
            display: inline-block;
            text-decoration: none;
            color: black;
            padding: 20px;
            border: 1px solid black;
            border-radius: 50px;
            font-size: 12pt;
            box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
            transition: all 0.3s cubic-bezier(.25,.8,.25,1);
            cursor: pointer;
            user-select: none;
        }

        .btn:hover {
            box-shadow: 0 14px 28px rgba(0,0,0,0.25), 0 10px 10px rgba(0,0,0,0.22);
            text-decoration: none;
            color: black;
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
        var user = JSON.parse("{{ Auth::check() ? Auth::user() : 0 }}".replaceAll("&quot;", "\""));
        var userLvl, userXp;
        if(user){
            userLvl = user.level;  // felhasználó szintje
            userXp = user.experience_points; // felhasználó xp-je
            userXp = userXp - (userLvl - 1) * 1000;
        }
        var myShips = 17;   // saját ép hajóelemek száma
        var enemyShips = 17; // ellenfél ép hajóelemeinek száma
        var colLetter = ["A", "B", "C", "D", "E", "F", "G", "H", "I", "J"]; // oszlopok kódjai
        var prevShotIsHit = false, prevRow, prevCol;  // információk az előző lövésről
        var messageBlock, enemyMapContainer, turnText, gameOverBlock, rewardText, userXpProgress, rewardProgress;   // html objektumok
        var numberOfShots = 0, numberOfHits = 0;
        var startTime = new Date(), endTime;
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
        ];  // ellenfél map-je

        const orientations = [
            [-1, 0],    // up
            [1, 0],     // down
            [0, -1],    // left
            [0, 1]      // right
        ];

        window.onload = function(){
            generateEnemyShips();   // ellenfél hajóinak kigenerálása
            // html objektumok lekérése
            messageBlock = document.getElementById('message-block');
            enemyMapContainer = document.getElementById("enemy-map");
            turnText = document.getElementById("turn");
            gameOverBlock = document.getElementById("game-over-block");
            if(user){
                rewardText = document.getElementById("reward");
                userXpProgress = document.getElementById("old-xp");
                rewardProgress = document.getElementById("new-xp");
            }
        }


        var interval;
        // saját kör
        function sectionClicked(event){
            ++numberOfShots;
            enemyMapContainer.classList.toggle("blocked");  // ellenfél map blokkolása
            var coords = event.target.id.split("-");    //
            var row = parseInt(coords[1]);              // koordináták kiolvasása
            var col = parseInt(coords[2]);              //
            event.target.classList.toggle("shootable"); // szekció nem lesz lőhető többet
            var message;
            if(enemyMap[row][col] == 0){
                // nincs találat
                event.target.classList.toggle("miss");  // eltüntetjük a szekciót
                turnText.innerHTML = "Computer's turn!";// szöveg módosítása
                message = "You shot "+row+colLetter[col]+", miss!";
                interval = setInterval(computerTurn, 1500); // ellenfél meghívása 1.5 másodpercenként
            }
            else{
                // van találat
                ++numberOfHits;
                event.target.classList.toggle("hit");   // animáció lejátszása
                setTimeout(() => {
                    enemyMapContainer.classList.toggle("blocked");
                }, 500);    // enemy map blokkolásának vége
                message = "You shot "+row+colLetter[col]+", hit!";
                --enemyShips;
            }
            messageBlock.innerHTML+='<p>'+message+'</p>';
            messageBlock.scrollTop = messageBlock.scrollHeight; // üzenet kiírása
            if(enemyShips == 0) gameOver(); // ha elfogytak az ellenfél hajóelemei, akkor vége
        }

        // ellenfél köre
        function computerTurn(){
            var row, col;
            if(prevShotIsHit){
                // ha az előző lövés találat volt
                for(var orient of orientations){
                    // kersünk egy szekciót a koordináta mellett, ahova lehet lőni (fel, le, balra, jobbra)
                    var stepRow = orient[0];
                    var stepCol = orient[1];
                    if(prevRow+stepRow < 0 || prevRow+stepRow > 9 || prevCol+stepCol < 0 || prevCol+stepCol > 9)
                        continue;
                    else if(myMap[prevRow+stepRow][prevCol+stepCol] == 9){
                        continue;
                    }
                    else{
                        row = prevRow+stepRow;
                        col = prevCol+stepCol;
                        break;
                    }
                }
            }
            if(!row && !col){
                // ha nem volt az előző lövés találat vagy nem tud a mellé lőni
                prevShotIsHit = false;
                // új koordináták generálása
                do{
                    row = Math.floor(Math.random() * 10);
                    col = Math.floor(Math.random() * 10);
                }while(myMap[row][col] == 9);
            }
            if(myMap[row][col] == 0){
                // nincs találat
                document.getElementById("my-"+row+"-"+col).classList.toggle("miss");    // eltüntetjük a szekciót
                myMap[row][col] = 9;
                clearInterval(interval);    // a computer leáll a lövésekkel
                enemyMapContainer.classList.toggle("blocked");  // kiszedjük az ellenfél map-jéről a blokkolást
                turnText.innerHTML = "Your turn!";
                message = "Computer shot "+row+colLetter[col]+", miss!";
            }
            else{
                // van találat
                var section = document.getElementById("my-"+row+"-"+col);
                section.removeChild(section.children[0]);   // hajó eltávolítása
                section.classList.toggle("hit");    // animáció lejátszása
                myMap[row][col] = 9;
                --myShips;
                message = "Computer shot "+row+colLetter[col]+", hit!";
                prevShotIsHit = true;
                prevRow = row;
                prevCol = col;
            }
            messageBlock.innerHTML+='<p>'+message+'</p>';
            messageBlock.scrollTop = messageBlock.scrollHeight; // üzenet kiírása
            if(myShips == 0){   // ha elfogynak a saját hajóelemeink, vége
                clearInterval(interval);
                gameOver();
            }
        }

        // játék vége
        function gameOver(){
            var youAreTheWinner = enemyShips == 0;
            if(user){
                endTime = new Date();
                var playedTime = Math.floor((endTime - startTime) / 1000);
                var reward = Math.floor((numberOfHits / numberOfShots) * (34 / playedTime) * 1000) + (youAreTheWinner ? 100 : 0);
                var userXpWidth = Math.floor(userXp / 10);
                var rewardWidth = Math.floor(reward / 10);
                rewardText.innerHTML = "+" + reward + " XP";
                userXpProgress.style.width = userXpWidth + "%";
                rewardProgress.style.width = rewardWidth + "%";
            }
            // üzenet beállítása és megjelenítése
            var title;
            if(youAreTheWinner){
                title = "You Won!";
            }
            else{
                title = "Computer Won!";
            }
            gameOverBlock.querySelector("#title").innerHTML = title;
            gameOverBlock.classList.toggle("d-none");
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