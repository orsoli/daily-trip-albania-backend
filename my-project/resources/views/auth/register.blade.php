@extends('layouts.create-or-update-user')

@section('form-header', __('static.addUser'))

@section('form-action')
{{route('register')}}
@endsection

@section('create-or-update-btn', __('static.addUser'))
