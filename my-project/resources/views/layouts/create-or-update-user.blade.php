@extends('layouts.app')

@section('title', __('static.addUser') . ' | ' . config('app.name'))

@section('content')
{{-- Title --}}
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('static.addUser') }}</div>

                <div class="card-body">
                    <form method="POST" action="@yield('route')">
                        @csrf
                        {{-- Role Input --}}
                        <div class="row mb-3">
                            <label for="role" class="col-md-4 col-form-label text-md-end">{{__('static.role')}}</label>

                            <div class="col-md-6">
                                <select id="role" class="form-select @error('role') is-invalid @enderror" name="role"
                                    required>
                                    <option value="" selected disabled>{{__('static.select_role')}} . . .</option>
                                    @foreach ($roles as $role)
                                    <option value="{{ $role->id }}" {{ old('role')==$role->id ? "selected" : "" }}>{{
                                        $role->name }}</option>
                                    @endforeach
                                </select>
                                {{-- Role Error --}}
                                @error('role')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        {{-- Name Input --}}
                        <div class="row mb-3">
                            <label for="first_name" class="col-md-4 col-form-label text-md-end">{{
                                __('static.first_name')}}
                            </label>

                            <div class="col-md-6">
                                <input id="first_name" type="text"
                                    class="form-control @error('first_name') is-invalid @enderror" name="first_name"
                                    value="{{ old('first_name') }}" required autocomplete="first_name" autofocus>
                                {{-- FirstName Error --}}
                                @error('first_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        {{-- LastName Input --}}
                        <div class="row mb-3">
                            <label for="last_name" class="col-md-4 col-form-label text-md-end">{{
                                __('static.last_name')}}</label>

                            <div class="col-md-6">
                                <input id="last_name" type="text"
                                    class="form-control @error('last_name') is-invalid @enderror" name="last_name"
                                    value="{{ old('last_name') }}" required autocomplete="last_name" autofocus>
                                {{-- Name Error --}}
                                @error('last_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        {{-- Email Address Input --}}
                        <div class="row mb-3">
                            <label for="email"
                                class="col-md-4 col-form-label text-md-end">{{__('static.email_address')}}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') }}" required autocomplete="email">
                                {{-- Email Error --}}
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        {{-- Date of birth Input --}}
                        <div class="row mb-3">
                            <label for="date_of_birth"
                                class="col-md-4 col-form-label text-md-end">{{__('static.dob')}}</label>

                            <div class="col-md-6">
                                <input id="date_of_birth" type="date"
                                    class="form-control @error('date_of_birth') is-invalid @enderror"
                                    name="date_of_birth" value="{{ old('date_of_birth') }}" required
                                    autocomplete="bday">
                                {{-- DOB Error --}}
                                @error('date_of_birth')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        {{-- Personal nr Input --}}
                        <div class="row mb-3">
                            <label for="personal_nr"
                                class="col-md-4 col-form-label text-md-end">{{__('static.personal_nr')}}</label>

                            <div class="col-md-6">
                                <input id="personal_nr" type="text"
                                    class="form-control @error('personal_nr') is-invalid @enderror" name="personal_nr"
                                    value="{{ old('personal_nr') }}" required autocomplete="personal_nr">
                                {{-- Personal_nr Error --}}
                                @error('personal_nr')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        {{-- Password Input --}}
                        <div class="row mb-3">
                            <label for="password"
                                class="col-md-4 col-form-label text-md-end">{{__('static.password')}}</label>

                            <div class="col-md-6">
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    required autocomplete="new-password">
                                {{-- Password Error --}}
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        {{-- Confirm Password Input --}}
                        <div class="row mb-3">
                            <label for="password-confirm"
                                class="col-md-4 col-form-label text-md-end">{{__('static.confirm_password')
                                }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control"
                                    name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>
                        {{-- Submit Button --}}
                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('static.addUser') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection