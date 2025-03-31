@extends('layouts.app')

@section('title', __('static.bookings_panel'). ' | ' . config('app.name'))

@section('content')
<div class="container">

    {{-- Bookings Statistics btn --}}
    <div class="mb-4">
        <a class="btn btn-primary border rounded-5 text-secondary" data-tab='deleted_data'
            href="{{route('bookings.statistics')}}">{{__('bookings.statistics')}}</a>
    </div>

    <div class="my-card px-2 px-md-4">
        {{-- Users Table header navbars --}}
        <div class="card-header">

            @include('partials.nav-tabs', [
            'navTabs' => [
            [
            'title' => __('bookings.all_bookings'),
            'href' => route('bookings.index', ['all_status' => true])
            ],
            [
            'title' => __('bookings.active_bookings'),
            'href' => route('bookings.index')
            ],
            [
            'title' => __('bookings.pending_bookings'),
            'href' => route('bookings.index',['pending' => true])
            ]
            ],
            ])
        </div>

        {{-- Bookings Card --}}
        <div class="row row-cols-1 g-2">
            @if (isset($bookings))
            @foreach ($bookings as $booking)
            <div class="col">
                <a href="{{route('bookings.show', $booking)}}">
                    <div class="card my-card table-hover">
                        <div class="card-body d-flex">
                            <div class="text-center d-flex flex-column align-items-center">
                                <div class="">

                                </div>
                                <div class="card-title mt-2">
                                    <h2>
                                        {{$booking->guest_email}}
                                    </h2>
                                </div>
                            </div>
                            <div class="card-subtitle ms-4 overflow-scroll align-self-center" style="max-height: 150px">
                                <p>
                                    {{$booking->reservation_date}}
                                </p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
            {{-- Paginate links --}}
            <div class="mt-4">
                {{ $bookings->links('pagination::bootstrap-4') }}
            </div>
            @else
            <div class="my-card">
                <h1 class="text-secondary text-center py-4">{{__('static.empty')}}</h1>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

{{-- Script --}}
@section('add-script')
@vite(['resources/js/nav-tabs.js'])
@endsection

{{-- CSS --}}
@section('add-scss')
@vite(['resources/sass/components/header-table.scss'])
@endsection
