@extends('layouts.app')

@section('title', __('static.add'). ' or ' . __('static.update_user') . ' | ' . config('app.name'))

@section('content')
{{-- Title --}}
<div class="container">
    <div class="row justify-content-center pt-5">
        <div class="col-12 col-md-10">
            <div class="card my-card">
                <div class="user-logo">
                    @if (Route::is('register'))
                    <img src="{{asset('img/new-user.png')}}" alt="new-user-img" class="user-logo-img">
                    @else
                    <img src="{{asset('img/update-user.png')}}" alt="new-user-img" class="user-logo-img">
                    @endif
                </div>
                <div class="card-header">
                    <h2 class="pt-4">
                        @yield('form-header')
                    </h2>
                </div>

                <div class="card-body">
                    <form method="POST" action="@yield('form-action')">
                        @csrf
                        @yield('form-method')

                        <div class="row mb-3 px-4 px-md-5">
                            {{-- First Name --}}
                            <div class="col-12 col-md-6 input-container">
                                <input id="first_name" type="text"
                                    class="form-control text-light @error('first_name') is-invalid @enderror"
                                    name="first_name" value="{{ old('first_name', $user->first_name ?? '') }}" required
                                    autocomplete="first_name" autofocus>
                                <label for="first_name">{{
                                    __('static.first_name')}}
                                </label>
                                {{-- FirstName Error --}}
                                @error('first_name')
                                @include('partials.input-validation-error-msg')
                                @enderror
                            </div>

                            {{-- Last Name --}}
                            <div class="col-12 col-md-6 input-container">
                                <input id="last_name" type="text"
                                    class="form-control @error('last_name') is-invalid @enderror" name="last_name"
                                    value="{{ old('last_name', $user->last_name ?? '') }}" required
                                    autocomplete="last_name" autofocus>
                                <label for="last_name">{{
                                    __('static.last_name')}}</label>
                                {{-- Last Name Error --}}
                                @error('last_name')
                                @include('partials.input-validation-error-msg')
                                @enderror
                            </div>

                            {{-- Role Input --}}
                            <div class="col-6">
                                <select id="role"
                                    class="form-control bg-transparent rounded-5 mt-3 text-light @error('role') is-invalid @enderror"
                                    name="role" required>
                                    <option value="" selected disabled>
                                        {{__('static.select_role')}} . . .</option>
                                    @foreach ($roles as $role)
                                    <option value="{{ $role->id }}" {{ old('role_name', $user->role_id ?? '') ===
                                        $role->id ?
                                        "selected" : "" }}>{{$role->name }}</option>
                                    @endforeach
                                </select>
                                {{-- Role Error --}}
                                @error('role')
                                @include('partials.input-validation-error-msg')
                                @enderror
                            </div>

                            {{-- Date of birth Input --}}
                            <div class="col-6 input-container">
                                <input id="date_of_birth" type="date"
                                    class="form-control @error('date_of_birth') is-invalid @enderror"
                                    name="date_of_birth" value="{{ old('date_of_birth', $user->date_of_birth ?? '') }}"
                                    required autocomplete="date_of_birth">
                                <label for="date_of_birth">{{__('static.dob')}}</label>
                                {{-- DOB Error --}}
                                @error('date_of_birth')
                                @include('partials.input-validation-error-msg')
                                @enderror
                            </div>

                            {{-- Email address --}}
                            <div class="col-12 col-md-6 input-container">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email', $user->email ?? '') }}" required
                                    autocomplete="email">
                                <label for="email">{{__('static.email_address')}}</label>
                                {{-- Email Error --}}
                                @error('email')
                                @include('partials.input-validation-error-msg')
                                @enderror
                            </div>

                            {{-- Perosnal Number --}}
                            <div class="col-12 col-md-6 input-container">
                                <input id="personal_nr" type="text"
                                    class="form-control @error('personal_nr') is-invalid @enderror" name="personal_nr"
                                    value="{{ old('personal_nr', $user->personal_nr ?? '') }}" required
                                    autocomplete="personal_nr">
                                <label for="personal_nr">{{__('static.personal_nr')}}</label>
                                {{-- Personal_nr Error --}}
                                @error('personal_nr')
                                @include('partials.input-validation-error-msg')
                                @enderror
                            </div>

                            {{-- Password Input --}}
                            @if (request()->routeIs('register'))
                            <div class="col-12 col-md-6 input-container">
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    required autocomplete="new-password">
                                <label for="password">{{__('static.password')}}</label>
                                {{-- Password Error --}}
                                @error('password')
                                @include('partials.input-validation-error-msg')
                                @enderror
                            </div>

                            {{-- Confirm Password Input --}}
                            <div class="col-12 col-md-6 input-container">
                                <input id="password-confirm" type="password" class="form-control"
                                    name="password_confirmation" required autocomplete="new-password">
                                <label for="password-confirm">{{__('static.confirm_password')
                                    }}</label>
                            </div>
                            @endif

                            {{-- Submit Button --}}
                            <div class="col">
                                <button type="submit" class="btn btn-primary">
                                    @yield('create-or-update-btn')
                                </button>
                                <button type="reset" class="btn btn-warning">Reset</button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
