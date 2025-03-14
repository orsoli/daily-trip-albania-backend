@extends('layouts.app')

@section('title', __('static.add'). ' or ' . __('destinations.update_destinations') . ' | ' . config('app.name'))

@section('content')


<div class="container align-self-center">
    @include('partials.go-back-btn', ['route' => 'destinations.index'])
    <div class="row justify-content-center">
        <div class="col-12 col-md-10">
            <div class="card my-card">
                <div class="card-header">
                    {{-- Title --}}
                    <h2 class="pt-4">
                        @yield('form-header')
                    </h2>
                </div>
                <div class="card-body">
                    <form method="POST" action="@yield('form-action')" enctype="multipart/form-data" id="form">
                        @csrf
                        @yield('form-method')


                        <div class="row mb-3 px-4 px-md-5">
                            {{-- Thumbnail img --}}
                            @if (isset($destination))
                            <div class="col-12">
                                <div>
                                    @if ($destination->thumbnailExists)
                                    <img src="{{ $destination->thumbnail }}" alt="{{ $destination->slug  . 'image'}}"
                                        style="width:200px; height: 200px; object-fit: fill; margin: 20px; border-radius: 20px; box-shadow: 0 0 5px 5px rgba(255, 255, 255, 0.3);">
                                    @else
                                    <img src="{{ asset('storage/img/img-placeholder.png') }}"
                                        alt="{{ $destination->slug  . 'image'}}"
                                        style="width:200px; height: 200px; object-fit: fill; margin: 20px; border-radius: 20px; box-shadow: 0 0 5px 5px rgba(255, 255, 255, 0.3);">
                                    @endif
                                </div>
                            </div>
                            @endif
                            {{-- Thumbnail --}}
                            <div class="col-12 col-md-6 input-container">
                                <div class="position-relative">
                                    <input id="thumbnail" type="file"
                                        class="form-control text-light position-relative @error('thumbnail') is-invalid @enderror"
                                        name="thumbnail" value="{{ old('thumbnail', $destination->thumbnail ?? '') }}"
                                        autocomplete="thumbnail"
                                        accept="image/jpeg,image/png,image/jpg,image/gif,image/svg">
                                    <label for="thumbnail">{{
                                        __('static.image')}}
                                    </label>
                                    {{-- thumbnail Error --}}
                                    @error('thumbnail')
                                    @include('partials.input-validation-error-msg')
                                    @enderror
                                    {{-- Input instructions --}}
                                    @include('partials.input-instruction', ['instructionMessages' =>
                                    __('input-instruction.thumbnail') ])
                                </div>
                            </div>

                            {{-- Name --}}
                            <div class="col-12 col-md-6 input-container">
                                <div class="position-relative">
                                    <input id="name" type="text"
                                        class="form-control text-light position-relative @error('name') is-invalid @enderror"
                                        name="name" value="{{ old('name', $destination->name ?? '') }}" required
                                        autocomplete="name" autofocus>
                                    <label for="name">{{
                                        __('static.name')}} *
                                    </label>
                                    {{-- Name Error --}}
                                    @error('name')
                                    @include('partials.input-validation-error-msg')
                                    @enderror
                                    {{-- Input instructions --}}
                                    @include('partials.input-instruction', ['instructionMessages' =>
                                    __('input-instruction.name') ])
                                </div>
                            </div>

                            {{-- Region select --}}
                            <div class="col-6">
                                <div class="position-relative">
                                    @if (isset($region))
                                    <p class="fs-3 py-2"> Region: {{$region->name}} </p>
                                    @endif
                                    <select id="region" class="form-control bg-transparent rounded-5 mt-3 text-light @error('region')
                                                                                                is-invalid @enderror"
                                        name="region_id" required>
                                        <option value="" selected disabled>
                                            {{__('static.select_region')}} . . . *</option>
                                        @foreach ($regions as $region)
                                        <option value="{{ $region->id }}" {{ old('region_id', $destination->region_id ??
                                            '') ==
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

                            {{-- Country --}}
                            <div class="col-12 col-md-6 input-container">
                                <div class="position-relative">
                                    <input id="country" type="text"
                                        class="form-control text-light position-relative @error('country') is-invalid @enderror"
                                        name="country" value="{{ old('country', $destination->country ?? '') }}"
                                        required autocomplete="country">
                                    <label for="country">{{ __('static.country') }} *</label>
                                    {{-- Country Error --}}
                                    @error('country')
                                    @include('partials.input-validation-error-msg')
                                    @enderror
                                    {{-- Input instructions --}}
                                    @include('partials.input-instruction', ['instructionMessages' =>
                                    __('input-instruction.country') ])
                                </div>
                            </div>

                            {{-- City --}}
                            <div class="col-12 col-md-6 input-container">
                                <div class="position-relative">
                                    <input id="city" type="text"
                                        class="form-control text-light position-relative @error('city') is-invalid @enderror"
                                        name="city" value="{{ old('city', $destination->city ?? '') }}" required
                                        autocomplete="city">
                                    <label for="city">{{ __('static.city') }} *</label>
                                    {{-- City Error --}}
                                    @error('city')
                                    @include('partials.input-validation-error-msg')
                                    @enderror
                                    {{-- Input instructions --}}
                                    @include('partials.input-instruction', ['instructionMessages' =>
                                    __('input-instruction.city') ])
                                </div>
                            </div>

                            {{-- Nearest Airport --}}
                            <div class="col-12 col-md-6 input-container">
                                <div class="position-relative">
                                    <input id="nearest_airport" type="text"
                                        class="form-control text-light position-relative @error('nearest_airport') is-invalid @enderror"
                                        name="nearest_airport"
                                        value="{{ old('nearest_airport', $destination->nearest_airport ?? '') }}"
                                        autocomplete="nearest_airport" required>
                                    <label for="nearest_airport">{{ __('static.nearest_airport') }} *</label>
                                    {{-- Nearest Airport Error --}}
                                    @error('nearest_airport')
                                    @include('partials.input-validation-error-msg')
                                    @enderror
                                    {{-- Input instructions --}}
                                    @include('partials.input-instruction', ['instructionMessages' =>
                                    __('input-instruction.nearest_airport') ])
                                </div>
                            </div>

                            {{-- accommodations Check list --}}
                            <div class="col-12 col-lg-4 my-4">
                                <div class="position-relative">
                                    <span class="fs-3 py-2">{{ __('static.accommodations') }}:</span>
                                    @foreach ($accommodations as $accommodation)
                                    <div class="form-check">
                                        <input type="checkbox" id="accommodation_{{ $accommodation->id }}"
                                            name="accommodations[]" value="{{ $accommodation->id }}"
                                            class="form-check-input @error('accommodations') is-invalid @enderror" {{
                                            (old('accommodations') && in_array($accommodation->id,
                                        old('accommodations')))
                                        ||
                                        (isset($tour) &&
                                        $tour->accommodations->pluck('id')->contains($accommodation->id)) ? 'checked' :
                                        ''
                                        }}>
                                        <label class="form-check-label" for="accommodation_{{ $accommodation->id }}">
                                            {{ $accommodation->property_name }}
                                        </label>
                                    </div>
                                    @endforeach
                                    {{-- accommodations error --}}
                                    @error('accommodations')
                                    @include('partials.input-validation-error-msg')
                                    @enderror
                                </div>
                            </div>

                            {{-- Description --}}
                            <div class="col-12 col-lg-8 input-container">
                                <div class="position-relative">
                                    <textarea id="description" name="description"
                                        class="form-control @error('description') is-invalid @enderror" rows="8"
                                        maxlength="500" required autocomplete="description"
                                        autofocus>{{ old('description', $destination->description ?? '') }}</textarea>
                                    <label for="description">{{
                                        __('static.description')}} *</label>
                                    {{-- Description Error --}}
                                    @error('description')
                                    @include('partials.input-validation-error-msg')
                                    @enderror
                                    {{-- Input instructions --}}
                                    @include('partials.input-instruction', ['instructionMessages' =>
                                    __('input-instruction.description') ])
                                </div>
                            </div>

                            {{-- Price --}}
                            <div class="col-12 col-md-6 input-container">
                                <div class="position-relative">
                                    <input id="price" type="number"
                                        class="form-control @error('price') is-invalid @enderror" name="price"
                                        value="{{ old('price', $destination->price ?? '') }}" required
                                        autocomplete="price">
                                    <label for="price">{{__('static.price')}} *</label>
                                    {{-- price Error --}}
                                    @error('price')
                                    @include('partials.input-validation-error-msg')
                                    @enderror
                                    {{-- Input instructions --}}
                                    @include('partials.input-instruction', ['instructionMessages' =>
                                    __('input-instruction.price') ])
                                </div>
                            </div>

                            @if(Route::is('destinations.edit') && isset($destination) &&
                            $destination->gallery->isNotEmpty())
                            <!-- Display existing images if the destination has a gallery -->
                            <div class="mb-3">
                                <label class="form-label">{{__('static.gallery_images')}}:</label>
                                <div class="d-flex flex-wrap gap-3 mb-3">
                                    @foreach($destination->gallery as $image)
                                    <div class="position-relative" style="width: 100px; height: 100px;">
                                        @if ($image->urlExists)
                                        <img src="{{ $image->url }}" alt="Gallery Image"
                                            style="width:100%; height:100%; border-radius: 20px; box-shadow: 0 0 5px 5px rgba(255, 255, 255, 0.3);">
                                        @else
                                        <img src="{{ asset('storage/img/img-placeholder.png') }}" alt="Gallery Image"
                                            style="width:100%; height:100%; border-radius: 20px; box-shadow: 0 0 5px 5px rgba(255, 255, 255, 0.3);">
                                        @endif

                                        <!-- Checkbox to delete the image -->
                                        <div class="position-absolute top-0 start-0 mt-2 ms-2 z-index-1">
                                            <input type="checkbox" name="delete_gallery_images[]"
                                                value="{{ $image->id }}" class="form-check-input">
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                {{-- Input instructions on the create page --}}
                                @include('partials.input-instruction', ['instructionMessages' =>
                                __('input-instruction.delete_gallery_images'),
                                'class' => 'text-warning'])
                            </div>
                            @endif

                            {{-- Input ADD Gallery --}}
                            <div class="col-12 col-md-6 input-container">
                                <div class="position-relative">
                                    <input id="gallery" type="file"
                                        class="form-control text-light position-relative @error('gallery_images') is-invalid @enderror"
                                        name="gallery_images[]"
                                        accept="image/jpeg,image/png,image/jpg,image/gif,image/svg" multiple>
                                    <label for="gallery">{{ __('static.add') }} {{ __('static.gallery') }}</label>

                                    {{-- Display validation errors --}}
                                    @error('gallery_images')
                                    @include('partials.input-validation-error-msg')
                                    @enderror

                                    {{-- Input instructions on the create page --}}
                                    @include('partials.input-instruction', ['instructionMessages' =>
                                    __('input-instruction.gallery_images')])

                                </div>
                            </div>

                            {{-- Is_visible check box --}}
                            <div class="col-12 mt-3">
                                <div class="form-check">
                                    <input type="hidden" name="is_visible" value="0">
                                    <input class="form-check-input" type="checkbox" id="is_visible" name="is_visible"
                                        value="1" {{ old('is_visible', $destination->is_visible ?? false) ? 'checked' :
                                    '' }}>
                                    <label class="form-check-label text-light" for="is_visible">
                                        {{ __('static.visible') }}
                                    </label>
                                </div>
                                {{-- Input instructions --}}
                                @include('partials.input-instruction', ['instructionMessages' =>
                                __('input-instruction.is_active'), 'class' => 'text-warning'])
                            </div>



                            {{-- Submit Button --}}
                            <div class="col-12 text-center py-3">
                                <button type="submit" class="btn btn-primary" disabled>
                                    @yield('create-or-update-btn')
                                </button>
                                <button type="reset" class="btn btn-warning" disabled>Reset</button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('add-scss')
@vite(['resources/js/form-btn-disable.js'])
@endsection
