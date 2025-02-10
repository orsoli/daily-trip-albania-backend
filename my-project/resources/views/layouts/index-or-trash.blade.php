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
            @yield('actions-column')
        </tbody>
    </table>
    <div class="mt-4">
        {{ $users->links('pagination::bootstrap-4') }}
    </div>
</div>
@endsection

@section('add-script')
@vite(['resources/js/actions-btns.js',])
@endsection
