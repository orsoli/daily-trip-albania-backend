@extends('layouts.app')

@section('title', __('static.confirm_password') . ' | ' . config('app.name'))

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card my-card">
                <div class="card-header">{{ __('static.confirm_password') }}</div>

                <div class="card-body">
                    {{ __('static.confirm_password_before_continuing') }}

                    <form method="POST" action="{{ route('password.confirm') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('static.password')
                                }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    required autocomplete="current-password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('static.confirm_password') }}
                                </button>

                                @if (Route::has('password.request'))
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('static.forgot_your_password') }}
                                </a>
                                @endif
                            </div>
                        </div>
                    </form>
                    <div class="my-card-logo"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
