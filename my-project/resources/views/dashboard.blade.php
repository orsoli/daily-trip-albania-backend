@extends('layouts.app')

@section('title', __('static.dashboard') . ' | ' . config('app.name'))

@section('content')
<div class="container">
    {{-- Dashboard --}}
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
        <div class="col">
            <div class="my-card card text-center">
                <a href="{{route('user.show', auth()->user())}}">
                    <h2 class="text-secondary">
                        <i class="bi bi-person-circle me-3"></i> {{__('static.my_profile')}}
                    </h2>
                </a>
            </div>
        </div>
        <div class="col">
            <div class="my-card card text-center">
                <a href="#">
                    <h2 class="text-secondary">
                        <i class="bi bi-person-badge me-3"></i>{{__('static.destinations')}}
                    </h2>
                </a>
            </div>
        </div>
        <div class="col">
            <div class="my-card card text-center">
                <a href="#">
                    <h2 class="text-secondary">
                        <i class="bi bi-person-badge me-3"></i>{{__('static.destinations')}}
                    </h2>
                </a>
            </div>
        </div>
        <div class="col">
            <div class="my-card card text-center">
                <a href="#">
                    <h2 class="text-secondary">
                        <i class="bi bi-person-badge me-3"></i>{{__('static.destinations')}}
                    </h2>
                </a>
            </div>
        </div>
        <div class="col">
            <div class="my-card card text-center">
                <a href="#">
                    <h2 class="text-secondary">
                        <i class="bi bi-person-badge me-3"></i>{{__('static.destinations')}}
                    </h2>
                </a>
            </div>
        </div>
        <div class="col">
            <div class="my-card card text-center">
                <a href="#">
                    <h2 class="text-secondary">
                        <i class="bi bi-person-badge me-3"></i>{{__('static.destinations')}}
                    </h2>
                </a>
            </div>
        </div>
    </div>

</div>
@endsection
