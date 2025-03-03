@extends('layouts.create-or-update-tours')

@section('title', __('tours.create_new_tour') . ' | ' . config('app.name'))

@section('form-header', __('tours.create_new_tour'))

@section('form-action')
{{route('tours.store')}}
@endsection

@section('create-or-update-btn', __('static.add'))
