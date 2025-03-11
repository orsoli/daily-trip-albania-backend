@extends('layouts.app')

@section('title', __('static.Login') . ' | ' . config('app.name'))

@section('content')
<div class="container align-self-center">
    {{-- Include Notifications --}}
    @include('partials.notifications')
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8">
            <div class="card my-card position-relative">
                <div class="user-logo">
                    <img src="{{asset('storage/img/user.png')}}" alt="user-logo" class="user-logo-img">
                </div>
                <div class="card-body">
                    {{-- Log in form --}}
                    <form method="POST" action="{{ route('login') }}" class="pt-4">
                        <div class="login-description mb-4 text-center">
                            <h2 class="">
                                {{ __('static.Login') }}
                            </h2>
                            <p>
                                {{__('content.login_description')}}
                            </p>
                        </div>
                        @csrf

                        <div class="row mb-3">
                            {{-- Email --}}
                            <div class="col-md-8 input-container">
                                <div class="position-relative">
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email" autofocus>
                                    <label for="email">{{
                                        __('static.email_address')
                                        }}
                                    </label>
                                    {{-- Email errors --}}
                                    @error('email')
                                    <span class=" invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            {{-- Password --}}
                            <div class="col-md-8 input-container">
                                <div class="position-relative">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="current-password">
                                    <label for="password">{{ __('static.password')
                                        }}</label>
                                    {{-- Password errors --}}
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{
                                        old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('static.remember_me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('static.Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                <a class="btn btn-link text-light" href="{{ route('password.request') }}">
                                    {{ __('static.forgot_your_password') }}
                                </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
