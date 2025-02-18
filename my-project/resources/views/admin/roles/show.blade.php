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
                    @if ($role->slug !== 'super-admin')
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
                    @endif

                    {{-- Show Users of this Role Button --}}
                    <button class="btn btn-info text-light bg-transparent rounded-5 p-1 px-5 m-0" type="button"
                        data-bs-toggle="modal" data-bs-target="#usersRoleModal">

                        {{__('static.view-this-role-users')}}

                    </button>

                    <p class="card-text my-2"><i> {{$role->description}} </i></p>

                    {{-- logo --}}
                    <div class="logo w-25 m-auto">
                        <img src="{{asset('img/DailyTrip-logo.png')}}" alt="daily-trip-logo">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Deleting Modal -->
<div class="modal fade" id="deleteModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="deleteModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-light bg-danger">
                <h1 class="modal-title fs-5" id="deleteModalLabel"></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="deleteModalBody"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                <form action="" method="POST" id="deleteForm">
                    @csrf
                    @method('DELETE')

                    <button class="btn btn-danger" type="submit" value="delete">
                        Yes, Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- View this Role Users Modal --}}
<div class="modal fade" id="usersRoleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="usersRoleModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-light bg-primary">
                <h5 class="modal-title">
                    {{__('static.view-this-role-users')}}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body bg-dark">
                <ul class="list-unstyled">
                    @foreach ($role->users as $user)
                    <li class="mb-2">
                        <a href="{{ route('user.show', $user) }}" class="text-decoration-none">
                            <div class="my-card py-2">
                                <div class="card-body">
                                    <div class="row d-flex m-0">
                                        <div class="col fs-5 fw-bold">{{ $user->first_name }}</div>
                                        <div class="col fs-5 ">{{ $user->last_name }}</div>
                                        <div class="col fs-5 ">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
            <div class="modal-footer bg-dark">
                <button type="button" class="btn text-light btn-primary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('add-script')
@vite(['resources/js/actions-btns.js', 'resources/js/nav-tabs.js'])
@endsection
