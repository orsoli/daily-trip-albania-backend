@extends('layouts.create-or-update-destinations')

@section('title', __('destinations.update_destination') . ' | ' . config('app.name'))

@section('form-header', __('destinations.update_destination'))

@section('form-method')
@method('PUT')
@endsection

@section('form-action')
{{route('destinations.update', $destination->slug)}}
@endsection

@section('create-or-update-btn', __('static.update'))
