<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>OldButGold</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <script>
        var x = 0;
        function rotateShipsFunction() {
           var ships = document.getElementById("ships-container").getElementsByClassName("ship");
           console.log(ships);
    /*
            if(x == 0){
                document.getElementById("rot1").style.transform = "rotate(90deg)";
                document.getElementById("rot2").style.transform = "rotate(90deg)";
                document.getElementById("rot3").style.transform = "rotate(90deg)";
                document.getElementById("rot4").style.transform = "rotate(90deg)";
                document.getElementById("rot5").style.transform = "rotate(90deg)";
                x = 1;
            }

            else{
                document.getElementById("rot1").style.transform = "rotate(0deg)";
                document.getElementById("rot2").style.transform = "rotate(0deg)";
                document.getElementById("rot3").style.transform = "rotate(0deg)";
                document.getElementById("rot4").style.transform = "rotate(0deg)";
                document.getElementById("rot5").style.transform = "rotate(0deg)";
                x = 0;
            }
    */
            for(i of ships){
                i.classList.toggle("rotated");
            }
        }

        function allowDrop(ev) {
            ev.preventDefault();
        }

        function drag(ev) {
             ev.dataTransfer.setData("text", ev.target.id);
             console.log(ev);
        } 
        function drop(ev) {
            ev.preventDefault();
            var data = ev.dataTransfer.getData("text");
            ev.target.appendChild(document.getElementById(data));
            console.log(ev);
        }

        </script>

        <style>
            .rotated{
                transform: rotate(90deg);
            }
            html, body{
                background-color: white;
                font-family: "Nunito", sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }
            .full-height{
                height: 100vh;
            }
            .flex-center{
                align-items: center;
                display: flex;
                justify-content: center;
            }
            .position-ref{
                position: relative;
            }
            .top-right{
                position: absolute;
                right: 105px;
                top: 16px;
            }
            .top-left{
                position: absolute;
                left: 150px;
                top: 0px;
            }
            .register, .login, .BackToHome{
                margin-left: 15px;
                text-decoration: none;  
                font: 14.4px "Nunito", sans-serif;
                color: grey;
            }
            img{
                width: 180px;
            }
            .mess{
                position: absolute;
                font: 25px "Nunito", sans-serif;
                color: grey;
                top: 50px;
            }
            .row{
                display: flex;
            }
            .left-side{
                align-items: center;
                display: flex;
                justify-content: center;
                text-align: center;
                float: left;
                width: 400px;
                height: 400px; 
                margin-right: 50px;
            }
            .right-side{  
                align-items: center;
                display: flex;
                justify-content: center;
                float: left;
                width: 400px;
                height: 400px; 
                margin-left: 50px;
            }
            .sea{
                display: flex;
                flex-wrap: wrap;
                background-color: black;
                float: left;
                width: 420px;
                height: 420px; 
            }
            .StartGameAsGuest, .RotateShips{
                background-color: rgba(0,0,0,0.05);
                text-decoration: none;  
                font: 40px "Nunito", sans-serif;
                color: grey;
                box-shadow: 0px 0px 20px 20px rgba(0,0,0,0.3);
                border-radius: 50%;
                padding: 17px;
                margin-left: 25px;
            }
            .sea > div {
                background-color: #11B1FB;
                width: 40px;
                height: 40px;
                text-align: center;
                font-size: 10px;
                margin: 1px;
            }
            .ships-bottom {
                position: absolute;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 250px;
                width: 750px;
                margin-top: 350px;
            }
            .ship{
                border-radius: 40%;
                background-color: red;
            }
            .ships-bottom > div {
                position: relative;
                margin: 5px;
            }
            .five {
                position: absolute;
                height: 40px;
                width: 200px;
            }
            .four {
                position: absolute;
                height: 40px;
                width: 160px;
            }
            .tree {
                position: absolute;
                height: 40px;
                width: 120px;
            }
            .two {
                position: absolute;
                height: 40px;
                width: 80px;
            }
            .ships-title {
                position: absolute;
                top: 0px;
                text-decoration: none;  
                font: 25px "Nunito", sans-serif;
                color: grey;
            }
        </style>
    </head>
    <body>
            <div class="flex-center position-ref full-height">
                    <div class="top-left">
                        <a href="http://127.0.0.1:8000/">
                        <img src="./images/logo.jpg" alt="image"/>
                        </a>
                    </div>
                    <div class="top-right">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/home') }}" class="home">Home</a>
                        @else
                            <a href="{{ route('login') }}" class="login">Login</a>

                         @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="register">Registration</a>
                        @endif

                    @endif

                    </div>
                @endif
                <div class="mess">
                    <p>Drag and drop your ships to the sea !</p>
                </div>
                <div class="row">
                    <div class="left-side">
                        <a href="http://127.0.0.1:8000/StartGameAsGuest" class="StartGameAsGuest">Start Game</a>
                    </div>
                    <div class="sea">
                        <div ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                        <div ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                        <div ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                        <div ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                        <div ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                        <div ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                        <div ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                        <div ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                        <div ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                        <div ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                        <div ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                        <div ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                        <div ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                        <div ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                        <div ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                        <div ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                        <div ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                        <div ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                        <div ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                        <div ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                        <div ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                        <div ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                        <div ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                        <div ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                        <div ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                        <div ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                        <div ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                        <div ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                        <div ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                        <div ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                        <div ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                        <div ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                        <div ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                        <div ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                        <div ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                        <div ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                        <div ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                        <div ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                        <div ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                        <div ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                        <div ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                        <div ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                        <div ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                        <div ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                        <div ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                        <div ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                        <div ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                        <div ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                        <div ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                        <div ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                        <div ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                        <div ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                        <div ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                        <div ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                        <div ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                        <div ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                        <div ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                        <div ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                        <div ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                        <div ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                        <div ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                        <div ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                        <div ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                        <div ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                        <div ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                        <div ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                        <div ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                        <div ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                        <div ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                        <div ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                        <div ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                        <div ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                        <div ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                        <div ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                        <div ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                        <div ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                        <div ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                        <div ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                        <div ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                        <div ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                        <div ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                        <div ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                        <div ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                        <div ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                        <div ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                        <div ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                        <div ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                        <div ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                        <div ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                        <div ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                        <div ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                        <div ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                        <div ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                        <div ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                        <div ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                        <div ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                        <div ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                        <div ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                        <div ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                        <div ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                    </div>
                    <div class="right-side">
                        <p onclick="rotateShipsFunction()" class="RotateShips">Rotate ships</p>
                    </div>
                </div>
                <div id="ships-container"class="ships-bottom" >
                    <p class="ships-title"> Ships:<p>
                    <div id="rot1" class="five ship" draggable="true" ondragstart="drag(event)"></div>
                    <div id="rot2" class="four ship" draggable="true" ondragstart="drag(event)"></div>
                    <div id="rot3" class="tree ship" draggable="true" ondragstart="drag(event)"></div>
                    <div id="rot4" class="tree ship" draggable="true" ondragstart="drag(event)"></div>
                    <div id="rot5" class="two ship" draggable="true" ondragstart="drag(event)"></div>
                </div>
            </div>
    </body>
</html>
