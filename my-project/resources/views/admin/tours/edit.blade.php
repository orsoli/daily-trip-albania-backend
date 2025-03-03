@extends('layouts.create-or-update-tours')

@section('title', __('tours.update_tour') . ' | ' . config('app.name'))

@section('form-header', __('tours.update_tour'))

@section('form-action')
{{route('tours.update', $tour->id)}}
@endsection

@section('create-or-update-btn', __('static.update'))