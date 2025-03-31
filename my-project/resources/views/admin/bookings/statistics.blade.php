@extends('layouts.app')

@section('meta')
<meta name='statistics' content='@json($statistics ?? '')'>
@endsection

@section('title', __('static.bookings_statistics') . ' | ' . config('app.name'))

@section('content')
<div class="container">
    {{-- Go back button --}}
    @include('partials.go-back-btn', ['route' => 'bookings.index'])

    <div class="my-card text-secondary text-center p-2">
        {{-- Chart Title --}}
        <div class="chart-title text-decoration-underline py-2">
            <h2> {{__('bookings.statistics')}} </h2>
        </div>


        @if (isset($years))
        {{-- Select year --}}
        <div class="d-flex gap-2 p-3">
            <label for="years" class="fs-5"> {{__('static.select_year')}}: </label>
            <select name="years" id="years" class="form-control bg-transparent rounded-5 text-light w-auto py-0">
                @foreach ($years as $year)
                <option value={{$year}} @if ($loop->last) selected @endif> {{$year}} </option>
                @endforeach
            </select>
        </div>
        {{-- Chart --}}
        <div>
            <canvas id="bookingsStatisticsChart" class="border rounded-5 bg-primary bg-opacity-50 p-3"></canvas>
        </div>
        @else
        <h3 class="text-secondary text-center">
            {{__('static.empty')}}
        </h3>
        @endif
    </div>
</div>
@endsection

@section('add-script')
@vite (['resources/js/bookings-statistics.js'])
@endsection
