@extends('layouts.app')

@section('title', __('static.verify_email') . ' | ' . config('app.name'))

@section('content')
<div class="container">
    @include('partials.notifications')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card my-card">
                <h4 class="card-header">{{ __('static.verify_email') }}</h4>

                <div class="card-body">
                    @if (session('resent'))
                    <div class="alert alert-success" role="alert">
                        {{ __('static.verify_email_message') }}
                    </div>
                    @endif

                    {{ __('static.check_email') }}
                    {{ __('static.not_receive_email') }},
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline text-secondary">{{
                            __('static.click_here_to_request_another') }}</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
