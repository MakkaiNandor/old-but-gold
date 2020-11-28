@extends('layouts.app')

@section('content')
    @guest
        <guest-home-page logo="{{ asset('images/logo.png') }}" route="{{ route('guest.preparing') }}"></guest-home-page>
    @else
        <user-home-page user_data="{{ $user }}" sp_route="{{ route('singleplayer.preparing') }}"></user-home-page>
    @endguest
@endsection