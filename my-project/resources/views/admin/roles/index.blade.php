@extends('layouts.app')

@section('title', __('static.roles_panel'). ' | ' . config('app.name'))

@section('content')
<div class="container">
    {{-- Include notification --}}
    @include('partials.notifications')

    {{-- Roles cards --}}
    <div class="row row-cols-1 g-3">
        @foreach ($roles as $role)
        <div class="col">
            <a href="{{route('roles.index', $role)}}">
                <div class="card my-card">
                    <div class="card-body d-flex">
                        <div class="w-25">
                            <div class="role-logo" style="width: 100px">
                                @if ($role->slug === 'super-admin')
                                <img src="{{asset('img/super-admin.png')}}" alt="super-admin-logo">
                                @else
                                <img src="{{asset('img/roles-logo.png')}}" alt="roles-logo">
                                @endif
                            </div>
                            <div class="card-title">
                                <h2>
                                    {{$role->name}}
                                </h2>
                            </div>
                        </div>
                        <div class="card-subtitle ms-4">
                            <p>
                                {{$role->description}}
                            </p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
</div>
@endsection
