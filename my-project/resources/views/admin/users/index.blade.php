@extends('layouts.app')

@section('title', __('static.users_index'). ' | ' . config('app.name'))

@section('content')
<div class="container">
    {{-- Include Notifications --}}
    @include('partials.notifications')
    {{-- Users Table --}}
    <table class="table table-striped shadow">
        <caption>List of users</caption>
        <thead>
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
                    @include('partials.action-buttons', [
                    'show_href' => route('user.show', $user->id),
                    'edit_href' => route('user.edit', $user->id),
                    'destroy_action' => route('user.destroy',$user->id),
                    ])
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