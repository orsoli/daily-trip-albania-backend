@extends('layouts.app')

@section('title', __('static.add'). ' or ' . __('tours.update_tours') . ' | ' . config('app.name'))

@section('content')
{{-- Title --}}
<div class="container align-self-center">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10">
            <div class="card my-card">
                <div class="card-header">
                    <h2 class="pt-4">
                        @yield('form-header')
                    </h2>
                </div>

                <div class="card-body">
                    <form method="POST" action="@yield('form-action')">
                        @csrf
                        @yield('form-method')

                        <div class="row mb-3 px-4 px-md-5">
                            {{-- Thumbnail --}}
                            <div class="col-12 col-md-6 input-container">
                                <div class="position-relative">
                                    <input id="thumbnail" type="file"
                                        class="form-control text-light position-relative @error('thumbnail') is-invalid @enderror"
                                        name="thumbnail" value="{{ old('thumbnail', $tour->thumbnail ?? '') }}"
                                        autocomplete="thumbnail"
                                        accept="image/jpeg,image/png,image/jpg,image/gif,image/svg">
                                    <label for="thumbnail">{{
                                        __('static.image')}}
                                    </label>
                                    @if (Route::is('tours.create'))
                                    {{-- Input instructions --}}
                                    @include('partials.input-instruction', ['instructionMessages' =>
                                    __('input-instruction.thumbnail') ])
                                    @endif
                                    {{-- thumbnail Error --}}
                                    @error('thumbnail')
                                    @include('partials.input-validation-error-msg')
                                    @enderror
                                </div>
                            </div>

                            {{-- Title --}}
                            <div class="col-12 col-md-6 input-container">
                                <div class="position-relative">
                                    <input id="title" type="text"
                                        class="form-control text-light position-relative @error('title') is-invalid @enderror"
                                        name="title" value="{{ old('title', $tour->title ?? '') }}" required
                                        autocomplete="title" autofocus>
                                    <label for="title">{{
                                        __('static.title')}} *
                                    </label>
                                    @if (Route::is('tours.create'))
                                    {{-- Input instructions --}}
                                    @include('partials.input-instruction', ['instructionMessages' =>
                                    __('input-instruction.title') ])
                                    @endif
                                    {{-- Title Error --}}
                                    @error('title')
                                    @include('partials.input-validation-error-msg')
                                    @enderror
                                </div>
                            </div>

                            {{-- Duration --}}
                            <div class="col-12 col-md-6 input-container">
                                <div class="position-relative">
                                    <input id="duration" type="text"
                                        class="form-control text-light position-relative @error('duration') is-invalid @enderror"
                                        name="duration" value="{{ old('duration', $tour->duration ?? '') }}" required
                                        autocomplete="duration" autofocus>
                                    <label for="duration">{{
                                        __('static.duration')}} *
                                    </label>
                                    @if (Route::is('tours.create'))
                                    {{-- Input instructions --}}
                                    @include('partials.input-instruction', ['instructionMessages' =>
                                    __('input-instruction.duration') ])
                                    @endif
                                    {{-- duration Error --}}
                                    @error('duration')
                                    @include('partials.input-validation-error-msg')
                                    @enderror
                                </div>
                            </div>

                            {{-- Difficulty --}}
                            <div class="col-12 col-md-6 input-container">
                                <div class="position-relative">
                                    <input id="difficulty" type="text"
                                        class="form-control text-light position-relative @error('difficulty') is-invalid @enderror"
                                        name="difficulty" value="{{ old('difficulty', $tour->difficulty ?? '') }}"
                                        required autocomplete="difficulty" autofocus>
                                    <label for="difficulty">{{
                                        __('static.difficulty')}} *
                                    </label>
                                    @if (Route::is('tours.create'))
                                    {{-- Input instructions --}}
                                    @include('partials.input-instruction', ['instructionMessages' =>
                                    __('input-instruction.difficulty') ])
                                    @endif
                                    {{-- difficulty Error --}}
                                    @error('difficulty')
                                    @include('partials.input-validation-error-msg')
                                    @enderror
                                </div>
                            </div>

                            {{-- Guide select --}}
                            <div class="col-6">
                                <div class="position-relative">
                                    @if (isset($guide))
                                    <p class="fs-3 py-2"> Guide: {{$guide->first_name}} {{$guide->last_name}}
                                    </p>
                                    @endif
                                    <select id="guide" class="form-control bg-transparent rounded-5 mt-3 text-light @error('guide')
                                                                    is-invalid @enderror" name="guide" required>
                                        <option value="" selected disabled>
                                            {{__('static.select_guide')}} . . . *</option>
                                        @foreach ($guides as $guide)
                                        <option value="{{ $guide->id }}" {{ old('guide', $tour->guide_id ?? '') ==
                                            $guide->id ?
                                            "selected" : "" }}>{{$guide->first_name }} {{$guide->last_name}} </option>
                                        @endforeach
                                    </select>
                                    {{-- guide Error --}}
                                    @error('guide')
                                    @include('partials.input-validation-error-msg')
                                    @enderror
                                </div>
                            </div>

                            {{-- Region select --}}
                            <div class="col-6">
                                <div class="position-relative">
                                    @if (isset($region))
                                    <p class="fs-3 py-2"> Region: {{$region->name}} </p>
                                    @endif
                                    <select id="region" class="form-control bg-transparent rounded-5 mt-3 text-light @error('region')
                                                                    is-invalid @enderror" name="region" required>
                                        <option value="" selected disabled>
                                            {{__('static.select_region')}} . . . *</option>
                                        @foreach ($regions as $region)
                                        <option value="{{ $region->id }}" {{ old('region', $tour->region_id ?? '') ==
                                            $region->id ?
                                            "selected" : "" }}>{{$region->name }}</option>
                                        @endforeach
                                    </select>
                                    {{-- region Error --}}
                                    @error('region')
                                    @include('partials.input-validation-error-msg')
                                    @enderror
                                </div>
                            </div>

                            {{-- Destinations Check list --}}
                            <div class="col-12 col-md-4 my-4">
                                <div class="position-relative">
                                    <span class="fs-3 py-2">{{ __('static.select_destinations') }}:</span>
                                    @foreach ($destinations as $destination)
                                    <div class="form-check">
                                        <input type="checkbox" id="destination_{{ $destination->id }}"
                                            name="destinations[]" value="{{ $destination->id }}"
                                            class="form-check-input @error('destinations') is-invalid @enderror" {{
                                            in_array($destination->id, old('destinations', [])) ?
                                        'checked' : '' }}>
                                        <label class="form-check-label" for="destination_{{ $destination->id }}">
                                            {{ $destination->name }}
                                        </label>
                                    </div>
                                    @endforeach
                                    @error('destinations')
                                    @include('partials.input-validation-error-msg')
                                    @enderror
                                </div>
                            </div>

                            {{-- Categories Check list --}}
                            <div class="col-12 col-md-4 my-4">
                                <div class="position-relative">
                                    <span class="fs-3">{{ __('static.select_categories') }}:</span>
                                    @foreach ($categories as $category)
                                    <div class="form-check">
                                        <input type="checkbox" id="category_{{ $category->id }}" name="categories[]"
                                            value="{{ $category->id }}"
                                            class="form-check-input @error('categories') is-invalid @enderror" {{
                                            in_array($category->id,
                                        old('categories', [])) ? 'checked'
                                        : '' }}>
                                        <label class="form-check-label" for="category_{{ $category->id }}">
                                            {{ $category->name }}
                                        </label>
                                    </div>
                                    @endforeach
                                    @error('categories')
                                    @include('partials.input-validation-error-msg')
                                    @enderror
                                </div>
                            </div>

                            {{-- Services check list --}}
                            <div class="col-12 col-md-4 my-4">
                                <div class="position-relative">
                                    <span class="fs-3">{{ __('static.select_services') }}:</span>
                                    @foreach ($services as $service)
                                    <div class="form-check">
                                        <input type="checkbox" id="service_{{ $service->id }}" name="services[]"
                                            value="{{ $service->id }}"
                                            class="form-check-input @error('services') is-invalid @enderror" {{
                                            in_array($service->id,
                                        old('services',[])) ? 'checked' : ''
                                        }}>
                                        <label class="form-check-label" for="service_{{ $service->id }}">
                                            {{ $service->name }}
                                        </label>
                                    </div>
                                    @endforeach
                                    @error('services')
                                    @include('partials.input-validation-error-msg')
                                    @enderror
                                </div>
                            </div>

                            {{-- Price --}}
                            <div class="col-12 col-md-6 input-container">
                                <div class="position-relative">
                                    <input id="price" type="number"
                                        class="form-control @error('price') is-invalid @enderror" name="price"
                                        value="{{ old('price', $tour->price ?? '') }}" required autocomplete="price">
                                    <label for="price">{{__('static.price')}} *</label>
                                    @if (Route::is('tours.create'))
                                    {{-- Input instructions --}}
                                    @include('partials.input-instruction', ['instructionMessages' =>
                                    __('input-instruction.price') ])
                                    @endif
                                    {{-- price Error --}}
                                    @error('price')
                                    @include('partials.input-validation-error-msg')
                                    @enderror
                                </div>
                            </div>

                            {{-- Input Gallery --}}
                            <div class="col-12 col-md-6 input-container">
                                <div class="position-relative">
                                    <input id="gallery" type="file"
                                        class="form-control text-light position-relative @error('gallery_images') is-invalid @enderror"
                                        name="gallery_images[]"
                                        value="{{ old('gallery_images', $tour->gallery ?? '') }}" autocomplete="gallery"
                                        accept="image/jpeg,image/png,image/jpg,image/gif,image/svg" multiple>
                                    <label for="gallery">{{ __('static.gallery') }}</label>

                                    {{-- Input instructions on the create page --}}
                                    @if (Route::is('tours.create'))
                                    @include('partials.input-instruction', ['instructionMessages' =>
                                    __('input-instruction.gallery_images')])
                                    @endif

                                    {{-- Display validation errors --}}
                                    @error('gallery_images')
                                    @include('partials.input-validation-error-msg')
                                    @enderror
                                </div>
                            </div>

                            {{-- Description --}}
                            <div class="col-12 col-md-10 input-container">
                                <div class="position-relative">
                                    <textarea id="description" name="description"
                                        class="form-control @error('description') is-invalid @enderror" rows="4"
                                        maxlength="500" required autocomplete="description"
                                        autofocus>{{ old('description', $tour->description ?? '') }}</textarea>
                                    <label for="description">{{
                                        __('static.description')}} *</label>
                                    @if (Route::is('tours.create'))
                                    {{-- Input instructions --}}
                                    @include('partials.input-instruction', ['instructionMessages' =>
                                    __('input-instruction.description') ])
                                    @endif
                                    {{-- Last Name Error --}}
                                    @error('description')
                                    @include('partials.input-validation-error-msg')
                                    @enderror
                                </div>
                            </div>

                            {{-- Wheelschair_accessible --}}
                            <div class="col-12 mt-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="wheelchair_accessible"
                                        name="wheelchair_accessible" value="1" {{ old('wheelchair_accessible',
                                        $tour->wheelchair_accessible ?? false) ? 'checked' : '' }}>
                                    <label class="form-check-label text-light" for="wheelchair_accessible">
                                        {{ __('static.wheel_chair_accessible') }}
                                    </label>
                                </div>
                            </div>

                            {{-- Is_active check box --}}
                            <div class="col-12 mt-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active"
                                        value="1" {{ old('is_active', $tour->is_active ?? false) ? 'checked' : '' }}>
                                    <label class="form-check-label text-light" for="is_active">
                                        {{ __('static.is_active') }}
                                    </label>
                                </div>
                            </div>



                            {{-- Submit Button --}}
                            <div class="col-12 text-center py-3">
                                <button type="submit" class="btn btn-primary">
                                    @yield('create-or-update-btn')
                                </button>
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
