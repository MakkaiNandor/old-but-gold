@extends('layouts.app')

@section('content')
    <div class="pl-5 pr-5">
        <h2 id="title" class="text-center">Statistics</h2>
        <div class="row"> 
            <div id="left-side" class="col-sm border-right">
                <div id="gamesPieChart" class="chart my-5" style="position: static; height: 360px; width: 90%;"></div>
                <div id="gamesLineChart" class="chart my-5" style="position: static; height: 360px; width: 90%;"></div>
            </div>
            <div id="right-side" class="col-sm">

            </div>
        </div>
    </div>
@endsection

@section('page_style')
    <style>
        .vl {
            background-color: black;
            width: 1px;
            height: 100vh;
        }
        .chart {
        }
    </style>
@endsection

@section('page_script')
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    <script>
        var user = {!! Auth::user() !!};
        var playings = {!! $playings !!};
        var games = {!! $games !!};

        var victoriesData = [], defeatsData = [];
        var date = new Date(user.created_at);

        while(true){
            if(date.getTime() > Date.now()){
                break;
            }
            var victories = 0, defeats = 0;
            for(var game of games){
                var start = new Date(game.starting_time);
                if(start.getFullYear() == date.getFullYear() && start.getMonth() == date.getMonth() && start.getDate() == date.getDate()){
                    for(var playing of playings){
                        if(game.id == playing.game_id){
                            if(playing.is_winner == "1"){
                                ++victories;
                            }
                            else{
                                ++defeats;
                            }
                        }
                    }
                }
            }
            var newDate = new Date(date.getFullYear(), date.getMonth(), date.getDate(), 0, 0, 0, 0);
            victoriesData.push({
                x: newDate,
                y: victories
            });
            defeatsData.push({
                x: newDate,
                y: defeats
            });
            date.setDate(date.getDate() + 1);
        }

        window.onload = function() {
            var gamesPieChart  = new CanvasJS.Chart("gamesPieChart", {
                theme: "light2",
                animationEnabled: true,	
                title:{
                    text: "Victories and Defeats",
                    fontSize: 20
                },
                data: [
                {
                    type: "pie",
                    startAngle: 270,
                    yValueFormatString: "##0\"%\"",
                    indexLabel: "{label}: {y}",
                    dataPoints: [
                        {y: (user.victories * 100) / (user.played_games == 0 ? 1 : user.played_games), label: "Victories", color: 'green'},
                        {y: (user.defeats * 100) / (user.played_games == 0 ? 1 : user.played_games), label: "Defeats", color: 'red'}
                    ]
                }
                ]
            });
            gamesPieChart.render();

            var gamesLineChart = new CanvasJS.Chart("gamesLineChart", {
                animationEnabled: true,
                theme: "light2",
                title:{
                    text: "PLayed Games Daily",
                    fontSize: 20
                },
                axisY: {
                    title: "PLayed Games",
                    includeZero: true
                },
                data: [{        
                    type: "line",
                    color: "green",
                    showInLegend: true,
                    name: "Victories",
                    indexLabelFontSize: 16,
		            xValueFormatString: "DD MMM, YYYY",
                    dataPoints: victoriesData
                },{
                    type: "line",
                    color: "red",
                    name: "Defeats",
                    showInLegend: true,
                    indexLabelFontSize: 16,
		            xValueFormatString: "DD MMM, YYYY",
                    dataPoints: defeatsData
                }]
            });
            gamesLineChart.render();
        }

    </script>
@endsection