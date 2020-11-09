<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>OldButGold</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <style>
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
                position: relative;
                background-color: red;
                float: left;
                width: 100px;
                height: 300px; 
            }
            .right-side{
                position: relative;
                background-color: yellow;
                float: left;
                width: 100px;
                height: 300px; 
            }
            .sea{
                position: relative;
                background-color: blue;
                float: left;
                width: 400px;
                height: 400px; 
            }
            
        </style>
    </head>
    <body>
            <div class="flex-center position-ref full-height">
                    <div class="top-left">
                        <img src="./images/logo.jpg" alt="image"/>
                    </div>
                    <div class="top-right">
                    <a href="http://127.0.0.1:8000/" class="BackToHome">Back to home</a>
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
                    <div class="left-side"></div>
                    <div class="sea"></div>
                    <div class="right-side"></div>
                </div>
            </div>
    </body>
</html>
