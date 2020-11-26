@extends('layouts.app')

@section('content')
    <div class="pl-5 pr-5">
        <h2 id="title" class="text-center">Statistics</h2>
        <div class="row"> 
            <div id="left-side" class="col-sm border-right">
                <div id="gamesPieChart" class="chart my-5" style="position: static; height: 360px; width: 90%;"></div>
                <div id="gamesLineChart" class="chart my-5" style="position: static; height: 360px; width: 90%;"></div>
            </div>
            <div id="right-side" class="col-sm text-center">
                <table id="top-100"class="mt-5">
                    <tr>
                        <th>#</th>
                        <th>Lvl.</th>
                        <th>XP</th>
                        <th>Username</th>
                        <th>Victories</th>
                        <th>Defeats</th>
                    </tr>
                    @foreach(App\Models\User::orderBy('experience_points', 'desc')->take(100)->get() as $user)
                        @if($user->id == Auth::user()->id)
                            <tr key="{{ $user->id }}" style="background-color: yellow;">
                        @elseif($loop->index % 2 == 0)
                            <tr key="{{ $user->id }}" style="background-color: lightgray;">
                        @else
                            <tr key="{{ $user->id }}">
                        @endif
                            <td>{{ $loop->index + 1 }}</td>
                            <td>{{ $user->level }}</td>
                            <td>{{ $user->experience_points }}</td>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->victories }}</td>
                            <td>{{ $user->defeats }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@endsection

@section('page_style')
    <style>
        #right-side {
            height: 100vh;
            overflow: auto;
        }

        #top-100 {
            width: 90%;
            margin-left: auto;
            margin-right: auto;
        }

        #top-100 td {
            padding-top: 10px;
            padding-bottom: 10px;
        }
    </style>
@endsection

@section('page_script')
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    <script>
        var user = {!! Auth::user() !!};
        var games = {!! $games !!};

        window.onload = function() {
            var pieChart = createPieChart();
            var lineChart = createLineChart();
            pieChart.render();
            lineChart.render();
        }

        function createPieChart(){
            return new CanvasJS.Chart("gamesPieChart", {
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
        }

        function createLineChart(){
            [victoriesData, defeatsData] = getDataPoints();
            return new CanvasJS.Chart("gamesLineChart", {
                animationEnabled: true,
                theme: "light2",
                title:{
                    text: "PLayed Games Daily",
                    fontSize: 20
                },
                axisX: {
                    valueFormatString: "DD MMM, YYYY"
                },
                axisY: {
                    title: "PLayed Games",
                    includeZero: true
                },
                data: [{        
                    type: "line",
                    color: "green",
                    name: "Victories",
                    showInLegend: true,
                    dataPoints: victoriesData
                },{
                    type: "line",
                    color: "red",
                    name: "Defeats",
                    showInLegend: true,
                    dataPoints: defeatsData
                }]
            });
        }

        function getDataPoints(){
            var victoriesData = [], defeatsData = [];
            var date = new Date(user.created_at);
            date.setHours(0);
            date.setMinutes(0);
            date.setSeconds(0);
            date.setMilliseconds(0);

            while(true){
                if(date.getTime() > Date.now()){
                    break;
                }
                var victories = 0, defeats = 0;
                for(var game of games){
                    var start = new Date(game.starting_time);
                    if(start.getFullYear() == date.getFullYear() && start.getMonth() == date.getMonth() && start.getDate() == date.getDate()){
                        if(user.id == game.winner){
                            ++victories;
                        }
                        else{
                            ++defeats;
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

            return [victoriesData, defeatsData];
        }
    </script>
@endsection