@extends('layouts.app')

@section('content')
    <div class="container text-center">
        <h2>Drag and drop your ships to the sea</h2>
        <div class="row my-5">
            <div id="left-box" class="col">
                <a id="start-game-btn" class="action-btn" href="#">Start Game</a>
            </div>
            <div id="center-box" class="col-6">
                <table>
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
                            <td class="section"></td>
                            <td class="section"></td>
                            <td class="section"></td>
                            <td class="section"></td>
                            <td class="section"></td>
                            <td class="section"></td>
                            <td class="section"></td>
                            <td class="section"></td>
                            <td class="section"></td>
                            <td class="section"></td>
                        </tr>
                    @endfor
                </table>
            </div>
            <div id="right-box" class="col">
                <div id="rotate-ships-btn" class="action-btn">Rotate Ships</div>
            </div>
        </div>
        <hr />
        <h4>Ships:</h4>
        <div id="ship-box">
            <!-- @foreach([5, 4, 3, 3, 2] as $size)
                <div class="ship" style="height: {{ $size * 38 }}px;"></div>
            @endforeach -->
            <div class="ship"></div>
            <div class="ship"></div>
            <div class="ship"></div>
            <div class="ship"></div>
            <div class="ship"></div>
        </div>
    </div>
@endsection

@section('page_style')
    <style>
        .section {
            width: 38px;
            height: 38px;
            border: 2px solid white;
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

        #ship-box .ship {
            display: inline-block;
            width: 38px;
            height: 114px;
            border-radius: 50px;
            background-color: brown;
            margin-left: 10px;
            margin-right: 10px;
            transition: transform 1s ease-out;
        }

        .rotate-ship {
            transform: rotate(90deg);
        }
    </style>
@endsection

@section('page_script')
    <script>
        window.onload = function(){
            document.getElementById("rotate-ships-btn").addEventListener("click", function(){
                for(var ship of document.getElementsByClassName("ship")){
                    ship.classList.toggle("rotate-ship");
                }
            })
        }
    </script>
@endsection