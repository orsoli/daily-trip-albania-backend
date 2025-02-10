@extends('layouts.index-or-trash')

@section('title', __('static.users_trash'). ' | ' . config('app.name'))

@section('actions-column')
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
        'restore_href' => route('user.restore', $user->id),
        'user_name' => $user->first_name . ' ' . $user->last_name,
        'form_action' => route('user.forceDelete',$user->id),
        'modal_header' => __('static.permanently_deleting'),
        'modal_body' => __('static.sure_to_permanently_delete')
        ])
    </td>
</tr>
@endif
@endforeach
@endsection
