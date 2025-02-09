@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center p-5">
        <div class="col-sm-12 col-lg-6">
            <div class="card shadow">
                <div class="card-body">
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
                    <a href="#" class="card-link text-danger">{{__('static.delete')}}</a>
                    <a href="{{ route('password.request') }}"
                        class="card-link text-primary">{{__('static.reset_password')}}</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection