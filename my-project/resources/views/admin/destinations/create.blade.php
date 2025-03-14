@extends('layouts.create-or-update-destinations')

@section('title', __('destinations.create_new_destination') . ' | ' . config('app.name'))

@section('form-header', __('destinations.create_new_destination'))

@section('form-action')
{{route('destinations.store')}}
@endsection

@section('create-or-update-btn', __('static.add'))
