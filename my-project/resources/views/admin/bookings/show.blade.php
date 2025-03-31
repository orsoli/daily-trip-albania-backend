@extends('layouts.app')

@section('title', $booking->tour->title . ' ' . __('static.booking') . ' | ' . config('app.name'))

@section('content')
<div class="container align-self-center">

    {{-- Go back btn --}}
    @include('partials.go-back-btn', ['route' => 'bookings.index'])

    <div class="row justify-content-center pt-5">
        <div class="col-sm-12 col-lg-6">
            <div class="card my-card">
                <div class="card-body text-center">
                    <h5 class="card-title mt-3">
                        {{$booking->id}}
                    </h5>
                    <h4 class="card-subtitle mb-3 text-secondary"> {{$booking->guest_emial}}</h4>

                    <p class="card-text my-2"><i> {{$booking->note}} </i></p>

                    {{-- logo --}}
                    <div class="logo w-25 m-auto">
                        <img src="{{asset('storage/img/DailyTrip-logo.png')}}" alt="daily-trip-logo">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
