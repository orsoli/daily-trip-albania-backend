@extends('layouts.app')

@section('title', __('static.add_or_update'). ' ' . __('static.role') . ' | ' . config('app.name'))

@section('content')
<div class="container align-self-center">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10">
            <div class="card my-card">
                <div class="card-header">
                    @if (Route::is('roles.create'))
                    <h2 class="pt-4">
                        {{__('static.addRole')}}
                    </h2>
                    @endif
                    @if (Route::is('roles.edit'))
                    <h2 class="pt-4">
                        {{__('static.update_role')}}
                    </h2>
                    @endif
                </div>

                <div class="card-body">
                    <form method="POST"
                        action="{{Route::is('roles.create') ? route('roles.store') : route('roles.update', $role)}}">
                        @csrf
                        @if (Route::is('roles.edit'))
                        @method('PUT')
                        @endif
                        <div class="row mb-3 px-4 px-md-5">
                            {{-- Name --}}
                            <div class="col-12 col-md-6 input-container">
                                <div class="position-relative">
                                    <input id="name" type="text"
                                        class="form-control text-light @error('name') is-invalid @enderror" name="name"
                                        value="{{ old('name', $role->name ?? '') }}" required autocomplete="name"
                                        autofocus>
                                    <label for="name">{{
                                        __('static.name')}} *
                                    </label>
                                    {{-- Input instructions --}}
                                    @include('partials.input-instruction', ['instructionMessages' =>
                                    __('input-instruction.name') ])
                                    {{-- FirstName Error --}}
                                    @error('name')
                                    @include('partials.input-validation-error-msg')
                                    @enderror
                                </div>
                            </div>

                            {{-- Slug --}}
                            <div class="col-12 col-md-6 input-container">
                                <div class="position-relative">
                                    <input id="slug" type="text"
                                        class="form-control @error('slug') is-invalid @enderror" name="slug"
                                        value="{{ old('slug', $role->slug ?? '') }}" required autocomplete="slug"
                                        autofocus>
                                    <label for="slug">{{
                                        __('static.slug')}} *</label>
                                    {{-- Input instructions --}}
                                    @include('partials.input-instruction', ['instructionMessages' =>
                                    __('input-instruction.slug') ])
                                    {{-- Slug Error --}}
                                    @error('slug')
                                    @include('partials.input-validation-error-msg')
                                    @enderror
                                </div>
                            </div>

                            {{-- Description --}}
                            <div class="col-12 input-container">
                                <div class="position-relative">
                                    <input id="description" type="text" rows='4' maxlength="500"
                                        class="form-control @error('description') is-invalid @enderror"
                                        name="description" value="{{ old('description', $role->description ?? '') }}"
                                        required autocomplete="description" autofocus>
                                    <label for="description">{{
                                        __('static.role_description')}} *</label>
                                    {{-- Input instructions --}}
                                    @include('partials.input-instruction', ['instructionMessages' =>
                                    __('input-instruction.description') ])
                                    {{-- description Error --}}
                                    @error('description')
                                    @include('partials.input-validation-error-msg')
                                    @enderror
                                </div>
                            </div>

                            {{-- Submit Button --}}
                            <div class="col-12 text-center py-3">
                                @if(Route::is('roles.create'))
                                <button type="submit" class="btn btn-primary">
                                    {{__('static.addRole')}}
                                </button>
                                @endif
                                @if(Route::is('roles.edit'))
                                <button type="submit" class="btn btn-primary">
                                    {{__('static.update_role')}}
                                </button>
                                @endif
                                <button type="reset" class="btn btn-warning">Reset</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
