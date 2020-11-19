@extends('layouts.app')

@section('content')
    <div>
    </div>
@endsection

@section('page_style')
    <style>
    </style>
@endsection

@section('page_script')
    <script>
        var map = JSON.parse("{{ $map }}");
        console.log(map);
    </script>
@endsection