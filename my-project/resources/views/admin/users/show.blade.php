@extends('layouts.app')

@section('content')
<div class="container">
    {{-- Include Notifications --}}
    @include('partials.notifications')

    <div class="row justify-content-center pt-5">
        <div class="col-sm-12 col-lg-6">
            <div class="card my-card">
                <div class="card-body">
                    <div class="user-logo">
                        <img src="{{asset('img/user.png')}}" alt="profile-img" class="user-logo-img">
                    </div>
                    <h5 class="card-title">{{$user->first_name}} {{$user->last_name}} </h5>
                    <h6 class="card-subtitle mb-3 text-body-secondary"> {{$user->role->name}}</h6>
                    <p class="card-subtitle mb-1">{{__('static.personal_nr')}}: <strong>
                            {{$user->personal_nr}}
                        </strong>
                    </p>
                    <p class="card-subtitle mb-1">{{__('static.dob')}}: <strong> {{$user->date_of_birth}} </strong></p>
                    <p class="card-subtitle mb-1">{{__('static.email_address')}}: <strong> {{$user->email}} </strong>
                    </p>
                    <p class="card-subtitle mb-1">{{__('static.verified_email')}}: <strong> {{$user->email_verified_at
                            ? 'YES' : "NO"}} </strong></p>
                    <p class="card-text">{{__('static.role_description')}}: <br> <i> {{$user->role->description}}
                        </i></p>
                    <a href="{{route('user.edit', $user)}}" class="card-link text-warning">{{__('static.edit')}}</a>

                    <form action="{{route('user.destroy', $user->id)}}" method="POST">
                        @csrf
                        @method('DELETE')

                        <button class="btn text-danger p-0 m-0" type="submit" value="delete">
                            {{__('static.delete')}}
                        </button>
                    </form>

                    <a href="{{ route('password.request') }}"
                        class="card-link text-secondary">{{__('static.reset_password')}}</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
