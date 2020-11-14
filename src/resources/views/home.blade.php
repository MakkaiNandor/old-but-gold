@extends('layouts.app')

@section('content')
    @guest
        <div class="container text-center">
            <p class="mt-5 h4">The Battelship game is the best in the world, try it yourself now as guest or you can registrate!</p>
            <p><img src="./images/logo.png" alt="image"/></p>
            <p><a href="{{ route('PlayAsGuest') }}" class="btn btn-outlined-primary btn-lg rounded-circle p-4 border-dark">Play as guest</a></p>
        </div>
    @else
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Played games: {{ $user->played_games }}</div>

                        <div class="card-body">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif

                            {{ __('You are logged in!') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endguest
@endsection

@section('page_style')
    <style>
    </style>
@endsection

@section('page_script')
    <script>
        
    </script>
@endsection