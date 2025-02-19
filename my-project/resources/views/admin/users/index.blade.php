@extends('layouts.app')

@section('title', __('static.users_panel'). ' | ' . config('app.name'))

@section('content')
<div class="container">
    {{-- Include Notifications --}}
    @include('partials.notifications')

    <div class="my-card px-2 px-md-4">
        {{-- Users Table header navbars --}}
        <div class="card-header">
            <div class="navbars mb-4">
                <ul class="nav">
                    <li class="nav-item">
                        <a class="nav-link users-nav-link text-secondary" data-tab='all_users'
                            href="{{route('user.index', ['with_trashed' => true])}}">{{__('static.all_users')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link users-nav-link text-secondary" data-tab='active_users'
                            href="{{route('user.index')}}">{{__('static.active_users')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link users-nav-link text-secondary" data-tab='deleted_user'
                            href="{{route('user.index',['trashed' => true])}}">{{__('static.deleted_users')}}</a>
                    </li>
                </ul>
            </div>
        </div>

        {{-- Chck if table is not empty --}}
        @if ($users->isNotEmpty())
        <!-- Columns Head-->
        <div class="row text-info fw-bold px-3">
            @foreach ($columns as $column)
            <div
                class="col {{ $column === 'Id' || $column === __('static.email_address') || $column === __('static.personal_nr') ? 'd-none d-lg-flex' : '' }}">
                {{$column}}
            </div>
            @endforeach
        </div>

        <!-- User Card -->
        <div class="row g-2 mt-2">
            @foreach ($users as $user)
            <div class="col-12">
                <div class="my-card py-3">
                    <div class="card-body">
                        <div class="row align-items-center m-0">
                            <div class="col d-none d-lg-block">{{ $user->id }}</div>
                            <div class="col fw-bold">{{ $user->first_name }}</div>
                            <div class="col">{{ $user->last_name }}</div>
                            <div class="col">{{ $user->role->name }}</div>
                            <div class="col d-none d-lg-block">{{ $user->email }}</div>
                            <div class="col d-none d-lg-block">{{ $user->personal_nr }}</div>
                            <div class="col ">
                                @if (request()->query('trashed'))
                                @include('partials.action-buttons', [
                                'isShowPage' => false,
                                'restore_href' => route('user.restore', $user->id),
                                'data_name' => $user->first_name . ' ' . $user->last_name,
                                'form_action' => route('user.forceDelete', $user->id),
                                'modal_header' => __('static.permanently_deleting'),
                                'modal_body' => __('static.sure_to_permanently_delete')
                                ])
                                @elseif (request()->query('with_trashed'))
                                @if ($user->deleted_at !== null)
                                <strong class="text-danger">{{__('static.deleted_users')}}</strong>
                                @else
                                <strong class="text-success">{{__('static.active_users')}}</strong>
                                @endif
                                @else
                                @include('partials.action-buttons', [
                                'isShowPage' => false,
                                'show_href' => route('user.show', $user->id),
                                'edit_href' => route('user.edit', $user->id),
                                'data_name' => $user->first_name . ' ' . $user->last_name,
                                'form_action' => route('user.destroy', $user->id),
                                'modal_header' => __('static.deleting'),
                                'modal_body' => __('static.sure_to_delete')
                                ])
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>


        <div class="mt-4">
            {{ $users->links('pagination::bootstrap-4') }}
        </div>
        @else

        <h1 class="text-secondary text-center py-4">{{__('static.empty')}}</h1>

        @endif
    </div>

</div>
<!-- Modal -->
<div class="modal fade" id="deleteModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="deleteModalLabel" aria-hidden="true">
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
@endsection

@section('add-script')
@if (isset($users) && $users->count() && !request()->query('with_trashed'))
@vite(['resources/js/actions-btns.js', 'resources/js/nav-tabs.js'])
@else
@vite(['resources/js/nav-tabs.js'])
@endif
@endsection

@section('add-scss')
@vite(['resources/sass/components/header-table.scss'])
@endsection