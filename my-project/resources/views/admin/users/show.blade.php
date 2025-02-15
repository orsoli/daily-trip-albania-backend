@extends('layouts.app')

@section('content')
<div class="container">
    {{-- Include Notifications --}}
    @include('partials.notifications')

    <div class="row justify-content-center pt-5">
        <div class="col-sm-12 col-lg-6">
            <div class="card my-card">
                <div class="card-body text-center">
                    <div class="user-logo">
                        <img src="{{asset('img/user.png')}}" alt="profile-img" class="user-logo-img">
                    </div>
                    <h5 class="card-title mt-3">
                        {{$user->first_name}} {{$user->last_name}}
                        @if($user->email_verified_at)
                        <i class="bi bi-patch-check-fill"></i>
                        @endif
                    </h5>
                    <h4 class="card-subtitle mb-3 text-secondary"> {{$user->role->name}}</h4>
                    @if (auth()->user()->personal_nr === $user->personal_nr)
                    <div class="actions d-flex justify-content-center align-items-end gap-3 my-3">
                        <a href="{{route('user.edit', $user)}}"
                            class="btn btn-warning text-light bg-transparent rounded-5 p-1 px-5 m-0">{{__('static.edit')}}</a>
                        <a href="{{ route('password.request') }}"
                            class="card-link text-secondary">{{__('static.reset_password')}}</a>
                    </div>
                    @endif

                    <p class="card-text"><i> {{$user->role->description}}
                        </i></p>

                    <div class="details col-6 text-start m-auto">
                        <p class="card-subtitle mb-1">{{__('static.personal_nr')}}: <strong>
                                {{$user->personal_nr}}
                            </strong>
                        </p>
                        <p class="card-subtitle mb-1">{{__('static.dob')}}: <strong> {{$user->date_of_birth}} </strong>
                        </p>
                        <p class="card-subtitle mb-1">{{__('static.email_address')}}: <strong> {{$user->email}}
                            </strong>
                        </p>
                        <p class="card-subtitle mb-1">{{__('static.verified_email')}}: <strong>
                                {{$user->email_verified_at
                                ? 'YES' : "NO"}} </strong></p>
                    </div>

                    {{-- logo --}}
                    <div class="logo w-25 m-auto">
                        <img src="{{asset('img/DailyTrip-logo.png')}}" alt="daily-trip-logo">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
