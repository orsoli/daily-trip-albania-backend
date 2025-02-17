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
                        @if ($role->slug === 'super-admin')
                        <img src="{{asset('img/super-admin.png')}}" alt="super-admin-logo">
                        @else
                        <img src="{{asset('img/roles-logo.png')}}" alt="roles-logo">
                        @endif
                    </div>
                    <h5 class="card-title mt-3">
                        {{$role->name}}
                    </h5>
                    <h4 class="card-subtitle mb-3 text-secondary"> {{$role->slug}}</h4>
                    <div class="actions d-flex justify-content-center align-items-end gap-3 my-3">
                        @include('partials.action-buttons', [
                        'isShowPage' => true,
                        'edit_href' => route('roles.edit', $role->id),
                        'data_name' => $role->name,
                        'form_action' => route('roles.destroy', $role->id),
                        'modal_header' => __('static.deleting_role'),
                        'modal_body' => __('static.sure_to_delete_role')
                        ])
                    </div>

                    <p class="card-text"><i> {{$role->description}}</i></p>

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

@section('add-script')
@vite(['resources/js/actions-btns.js', 'resources/js/nav-tabs.js'])
@endsection
