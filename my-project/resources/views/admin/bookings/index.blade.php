@extends('layouts.app')

@section('title', __('static.bookings_statistics') . ' | ' . config('app.name'))

@section('content')
<div class="container">
    <div class="my-card text-secondary text-center p-2">
        <div class="chart-title py-2">
            <h2>Bookings Tour Statistics</h2>
        </div>
        <canvas id="myChart" class="border rounded-3 p-2 bg-primary w-75"></canvas>
    </div>
</div>
@endsection

@section('add-script')
@vite (['resources/js/statistics.js'])
@endsection
