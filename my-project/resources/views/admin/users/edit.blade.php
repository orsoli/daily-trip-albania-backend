@extends('layouts.create-or-update-user')

@section('title', __('static.update_user') . ' | ' . config('app.name'))

@section('form-header', __('static.update_user') . ' ' . $user->first_name)

@section('form-method')
@method('PUT')
@endsection

@section('form-action')
{{route('user.update', $user)}}
@endsection

@section('create-or-update-btn', __('static.update'))
