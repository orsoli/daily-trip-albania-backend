@extends('layouts.app')

@section('title', __('static.reset_password') . ' | ' . config('app.name'))

@section('content')
<div class="container">
    @include('partials.notifications')
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card my-card">
                <div class="card-header">{{ __('static.reset_password') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('static.email_address')
                                }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('static.send_password_reset_link') }}
                                </button>
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
