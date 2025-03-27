@extends('layouts.app')

@section('meta')
<meta name='tour_statistics' content='@json($tourStatistics ?? '')'>
@endsection

@section('title', __('static.dashboard') . ' | ' . config('app.name'))


@section('content') <div class="container">
    <div class="my-card p-3">
        {{-- Welcome title --}}
        <div class="slogan col-lg-5 text-light mb-3">
            <h3>
                {{__('static.hello')}}
                {{Auth::user()->first_name}} !
            </h3>
            <p>
                {{__('dashboard.slogan')}}
            </p>
        </div>

        <div class="fs-4 p-2 text-secondary">
            Overview
        </div>

        {{-- Total statistics --}}
        <div class="row row-cols-3 row-cols-md-5 mb-3 g-3">
            @foreach ($columns as $column)
            <div class="col">
                <div class="my-card bg-primary bg-opacity-50 text-center p-2">
                    <div class="badge text-bg-info rounded-pill">
                        {{$column['title']}}
                    </div>
                    <div class="fs-4 fw-bold text-secondary">
                        <i class="{{$column['icon']}}"></i>
                        <span class="ms-2"> {{$column['tot']}} </span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        {{-- Chart statistics --}}
        <div class="row mb-3">
            <div class="col align-content-center">
                @if (isset($tourStatistics))
                <canvas id="tourBookingsChart" class="border rounded-5 bg-primary bg-opacity-50 p-2"></canvas>
                @else
                <h3 class="text-secondary text-center">
                    {{__('static.empty')}}
                </h3>
                @endif
            </div>
            <div class="col col-lg-4 align-content-center">
                @if (isset($tourStatistics))
                <canvas id="bestTourChart"></canvas>
                @else
                <h3 class="text-secondary text-center">
                    {{__('static.empty')}}
                </h3>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('add-script')
@vite (['resources/js/dashboard/tour-bookings-statistics.js', 'resources/js/dashboard/best-tour-statistics.js'])
@endsection
