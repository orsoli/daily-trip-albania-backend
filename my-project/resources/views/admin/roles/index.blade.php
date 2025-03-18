@extends('layouts.app')

@section('title', __('static.roles_panel'). ' | ' . config('app.name'))

@section('content')
<div class="container">

    {{-- Roles cards --}}
    <div class="row row-cols-1 g-3">
        @foreach ($roles as $role)
        <div class="col">
            <a href="{{route('roles.show', $role)}}">
                <div class="card my-card">
                    <div class="card-body d-flex">
                        <div class="w-25 text-center d-flex flex-column align-items-center">
                            <div class="role-logo" style="width: 100px">
                                @if ($role->slug === 'super-admin')
                                <img src="{{asset('storage/img/super-admin.png')}}" alt="super-admin-logo">
                                @elseif ($role->slug === 'guide')
                                <img src="{{asset('storage/img/guide.png')}}" alt="super-admin-logo">
                                @else
                                <img src="{{asset('storage/img/roles-logo.png')}}" alt="roles-logo">
                                @endif
                            </div>
                            <div class="card-title mt-2">
                                <h2>
                                    {{$role->name}}
                                </h2>
                            </div>
                        </div>
                        <div class="card-subtitle ms-4 overflow-scroll align-self-center" style="max-height: 150px">
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