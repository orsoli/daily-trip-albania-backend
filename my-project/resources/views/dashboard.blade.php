@extends('layouts.app')

@section('title', __('static.dashboard') . ' | ' . config('app.name'))

@section('content')
<div class="container">
    {{-- Dashboard --}}
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{Auth::user()->role->name}} {{__('static.dashboard') }}</div>
                {{-- Card Body --}}
                <div class="card-body">
                    @if (Auth::user()->role->name === 'Admin')
                    <h3>Hello {{Auth::user()->first_name}}!</h3>
                    <p></p>
                    @endif

                    {{ __('static.logedIn') }}

                    <p>{{Auth::user()->role->description}}</p>

                </div>
            </div>
        </div>
    </div>

</div>
@endsection