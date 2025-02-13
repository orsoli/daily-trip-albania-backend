@extends('layouts.app')

@section('title', __('static.users_panel'). ' | ' . config('app.name'))

@section('content')
<div class="container">
    {{-- Include Notifications --}}
    @include('partials.notifications')
    {{-- Users Table --}}
    <table class="table table-striped shadow">
        <caption class="text-light">List of users</caption>
        <thead>
            <tr>
                <ul class="nav nav-tabs bg-secondary">
                    <li class="nav-item">
                        <a class="nav-link users-nav-link text-black active" data-tab='all_users'
                            href="{{route('user.index', ['with_trashed' => true])}}">{{__('static.all_users')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link users-nav-link text-black" data-tab='active_users'
                            href="{{route('user.index')}}">{{__('static.active_users')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link users-nav-link text-black" data-tab='deleted_user'
                            href="{{route('user.index',['trashed' => true])}}">{{__('static.deleted_users')}}</a>
                    </li>
                </ul>
            </tr>

            <tr>
                @foreach ($columns as $column)
                <th class="text-primary {{ $column === __('static.email_address') || $column === __('static.personal_nr') ? 'd-none d-lg-table-cell' : '' }}"
                    scope="col">
                    {{$column}}
                </th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
            @if ($user->id !== auth()->user()->id)
            <tr>
                <td> {{$user->id}} </td>
                <td> {{$user->first_name}} </td>
                <td> {{$user->last_name}} </td>
                <td> {{$user->role->name}} </td>
                <td class="d-none d-lg-table-cell"> {{$user->email}} </td>
                <td class="d-none d-lg-table-cell"> {{$user->personal_nr}} </td>

                <td>
                    @if (request()->query('trashed'))
                    @include('partials.action-buttons', [
                    'restore_href' => route('user.restore', $user->id),
                    'user_name' => $user->first_name . ' ' . $user->last_name,
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
                    'show_href' => route('user.show', $user->id),
                    'edit_href' => route('user.edit', $user->id),
                    'user_name' => $user->first_name . ' ' . $user->last_name,
                    'form_action' => route('user.destroy', $user->id),
                    'modal_header' => __('static.deleting'),
                    'modal_body' => __('static.sure_to_delete')
                    ])
                    @endif
                </td>
            </tr>
            @endif
            @endforeach
        </tbody>
    </table>
    <div class="mt-4">
        {{ $users->links('pagination::bootstrap-4') }}
    </div>
</div>
@endsection

@section('add-script')
@vite(['resources/js/actions-btns.js', 'resources/js/nav-tabs.js'])
@endsection
