@extends('layouts.app')

@section('content')
    <h4 class="text-center">Your turn</h4>
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
                            <td><div id="enemy-{{ $i }}-{{ $j }}" class="section"></div></td>
                        @endfor
                    </tr>
                @endfor
            </table>
        </div>
    </div>
@endsection

@section('page_style')
    <style>
        .section {
            position: relative;
            width: 38px;
            height: 38px;
            background-color: lightblue;
        }

        #my-map {
            margin-right: 0;
            margin-left: auto;
        }

        #message-block {
            border: 1px solid gray;
            border-radius: 50px;
            width: 200px;
            overflow: auto;
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
    </script>
@endsection