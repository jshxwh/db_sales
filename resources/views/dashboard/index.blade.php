@extends('layouts.base')
@section('body')
    <style>
        .container-fluid {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;

            /* fraction*/
        }
    </style>

    <div class="container-fluid">
        <div class="f">
            <canvas id="titleChart"></canvas>
        </div>

        <div class="s">
            <canvas id="salesChart"></canvas>
        </div>

        <div class="t">
            <canvas id="itemsChart"></canvas>
        </div>
    </div>
@endsection
