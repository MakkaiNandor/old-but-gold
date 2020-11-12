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
            .center{
                display: relative;
                text-align: center;
            }
            img{
                margin-bottom: 10px;
            }
            .register, .login{
                margin-left: 15px;
                text-decoration: none;  
                font: 14.4px "Nunito", sans-serif;
                color: grey;
            }
            .PlayAsGuest{
                background-color: rgba(0,0,0,0.05);
                text-decoration: none;  
                font: 40px "Nunito", sans-serif;
                color: grey;
                box-shadow: 0px 0px 20px 20px rgba(0,0,0,0.3);
                border-radius: 50%;
                padding: 17px;
                margin-left: 25px;
            }
            .battleship{
                font: 20px "Nunito", sans-serif;
                color: grey;
            }
        </style>
    </head>
    <body>
            <div class="flex-center position-ref full-height">
                    <div class="center">
                        <p class="battleship">The Battelship game is the best in the world, try it yourself now as guest or you can registrate!</p>
                        <p><img src="./images/logo.jpg" alt="image"/></p>
                        <p><a href="http://127.0.0.1:8000/PlayAsGuest" class="PlayAsGuest">Play as guest</a></p>
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
            </div>
    </body>
</html>
