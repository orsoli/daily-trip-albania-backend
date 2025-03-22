@extends('layouts.app')

@section('title', __('static.add'). ' or ' . __('tours.update_tours') . ' | ' . config('app.name'))

@section('content')


<div class="container align-self-center">
    @include('partials.go-back-btn', ['route' => 'tours.index'])
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
                            @if (isset($tour))
                            <div class="col-12">
                                <div>
                                    @if ($tour->thumbnail && @get_headers($tour->thumbnail))
                                    <img src="{{ $tour->thumbnail }}" alt="{{ $tour->slug  . 'image'}}"
                                        style="width:200px; height: 200px; object-fit: fill; margin: 20px; border-radius: 20px; box-shadow: 0 0 5px 5px rgba(255, 255, 255, 0.3);">
                                    @else
                                    <img src="{{ asset('storage/img/img-placeholder.png') }}"
                                        alt="{{ $tour->slug  . 'image'}}"
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
                                        name="thumbnail" value="{{ old('thumbnail', $tour->thumbnail ?? '') }}"
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
                                    {{-- Title Error --}}
                                    @error('title')
                                    @include('partials.input-validation-error-msg')
                                    @enderror
                                    {{-- Input instructions --}}
                                    @include('partials.input-instruction', ['instructionMessages' =>
                                    __('input-instruction.title') ])
                                </div>
                            </div>

                            {{-- Itineraries --}}
                            <div class="row border rounded-4 py-4 my-3 position-relative">

                                {{-- Create itinerary label --}}
                                <div
                                    class="col border rounded-5 bg-primary w-auto px-2 position-absolute top-0 start-10 translate-middle-y">
                                    {{__('static.create_itinerary')}}
                                </div>

                                @if (Route::is('tours.edit'))

                                <div class="col" id="itineraries-container" data-day-label="{{ __('static.day') }}"
                                    data-start-time-label="{{ __('itineraries.start_time') }}"
                                    data-lunch-time-label="{{ __('itineraries.lunch_time') }}"
                                    data-end-time-label="{{ __('itineraries.end_time') }}"
                                    data-activities-label="{{ __('static.activities') }}">
                                    @if($tour->itineraries)
                                    @include('partials.itinerary-inputs', [
                                    'tour' => $tour,
                                    ])
                                    @endif
                                </div>

                                @else

                                <div class="col" id="itineraries-container" data-day-label="{{ __('static.day') }}"
                                    data-start-time-label="{{ __('itineraries.start_time') }}"
                                    data-lunch-time-label="{{ __('itineraries.lunch_time') }}"
                                    data-end-time-label="{{ __('itineraries.end_time') }}"
                                    data-activities-label="{{ __('static.activities') }}"></div>

                                @endif


                                {{-- Add new itinerary button --}}
                                <div class="col-12 text-center py-3">
                                    <button type="button" class="text-light bg-primary bg-opacity-75 border rounded-5"
                                        onclick="addItinerary()">
                                        <i class="bi bi-patch-plus"></i>
                                        {{__('itineraries.add_itinerary')}}
                                    </button>
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
                                    {{-- duration Error --}}
                                    @error('duration')
                                    @include('partials.input-validation-error-msg')
                                    @enderror
                                    {{-- Input instructions --}}
                                    @include('partials.input-instruction', ['instructionMessages' =>
                                    __('input-instruction.duration') ])
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
                                    {{-- difficulty Error --}}
                                    @error('difficulty')
                                    @include('partials.input-validation-error-msg')
                                    @enderror
                                    {{-- Input instructions --}}
                                    @include('partials.input-instruction', ['instructionMessages' =>
                                    __('input-instruction.difficulty') ])
                                </div>
                            </div>

                            {{-- Selecting list --}}
                            <div class="row border rounded-4 py-2 my-3 position-relative">

                                {{-- Container label --}}
                                <div
                                    class="col border rounded-5 bg-primary w-auto px-2 position-absolute top-0 start-10 translate-middle-y">
                                    {{__('static.select_options')}}
                                </div>

                                {{-- Guide select --}}
                                <div class='col-4'>
                                    <div class="position-relative">
                                        @if (isset($guide))
                                        <p class="fs-3 py-2"> Guide: {{$guide->first_name}} {{$guide->last_name}}
                                        </p>
                                        @endif
                                        <select id="guide" class="form-control bg-transparent rounded-5 mt-3 text-light @error('guide')
                                                                        is-invalid @enderror" name="guide_id" required>
                                            <option value="" selected disabled>
                                                {{__('static.select_guide')}} . . . *</option>
                                            @foreach ($guides as $guide)
                                            <option value="{{ $guide->id }}" {{ old('guide_id', $tour->guide_id ?? '')
                                                ==
                                                $guide->id ?
                                                "selected" : "" }}>{{$guide->first_name }} {{$guide->last_name}}
                                            </option>
                                            @endforeach
                                        </select>
                                        {{-- guide Error --}}
                                        @error('guide')
                                        @include('partials.input-validation-error-msg')
                                        @enderror
                                    </div>
                                </div>

                                {{-- Region select --}}
                                <div class='col-4'>
                                    <div class="position-relative">
                                        @if (isset($region))
                                        <p class="fs-3 py-2"> Region: {{$region->name}} </p>
                                        @endif
                                        <select id="region" class="form-control bg-transparent rounded-5 mt-3 text-light @error('region')
                                                                        is-invalid @enderror" name="region_id"
                                            required>
                                            <option value="" selected disabled>
                                                {{__('static.select_region')}} . . . *</option>
                                            @foreach ($regions as $region)
                                            <option value="{{ $region->id }}" {{ old('region_id', $tour->region_id ??
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

                                {{-- Accomodation select --}}
                                <div class='col-4'>
                                    <div class="position-relative">
                                        @if (isset($accomodation))
                                        <p class="fs-3 py-2"> Accommodation: {{$accommodation->name}} </p>
                                        @endif
                                        <select id="accommodation" class="form-control bg-transparent rounded-5 mt-3 text-light @error('accommodation')
                                                                        is-invalid @enderror" name="accommodation_id">
                                            <option value="" selected disabled>
                                                {{__('static.select_accommodation')}} . . . </option>
                                            @foreach ($accommodations as $accommodation)
                                            <option value="{{ $accommodation->id }}" {{ old('accommodation_id', $tour->
                                                accommodation_id ??
                                                '') ==
                                                $accommodation->id ?
                                                "selected" : "" }}>{{$accommodation->property_name }}</option>
                                            @endforeach
                                        </select>
                                        {{-- accommodation Error --}}
                                        @error('accommodation')
                                        @include('partials.input-validation-error-msg')
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- Check lists container --}}
                            <div class="row border rounded-4 my-3 position-relative">

                                {{-- Container title --}}
                                <div
                                    class="col border rounded-5 bg-primary w-auto px-2 position-absolute top-0 start-10 translate-middle-y">
                                    {{__('static.check_options')}}
                                </div>

                                {{-- Destinations Check list --}}
                                <div class="col-12 col-md-4 my-4 overflow-scroll" style="height: 200px">
                                    <span class="fs-3 py-2">{{ __('static.select_destinations') }}:</span>
                                    @foreach ($destinations as $destination)
                                    <div class="form-check">
                                        <input type="checkbox" id="destination_{{ $destination->id }}"
                                            name="destinations[]" value="{{ $destination->id }}"
                                            class="form-check-input @error('destinations') is-invalid @enderror" {{
                                            (old('destinations') && in_array($destination->id, old('destinations')))
                                        ||
                                        (isset($tour) &&
                                        $tour->destinations->pluck('id')->contains($destination->id)) ? 'checked' :
                                        ''
                                        }}>
                                        <label class="form-check-label" for="destination_{{ $destination->id }}">
                                            {{ $destination->name }}
                                        </label>
                                    </div>
                                    @endforeach
                                    {{-- Destinations error --}}
                                    @error('destinations')
                                    @include('partials.input-validation-error-msg')
                                    @enderror
                                </div>

                                {{-- Categories Check list --}}
                                <div class="col-12 col-md-4 my-4 overflow-scroll" style="height: 200px">
                                    <div class="position-relative">
                                        <span class="fs-3">{{ __('static.select_categories') }}:</span>
                                        @foreach ($categories as $category)
                                        <div class="form-check">
                                            <input type="checkbox" id="category_{{ $category->id }}" name="categories[]"
                                                value="{{ $category->id }}"
                                                class="form-check-input @error('categories') is-invalid @enderror" {{
                                                (old('categories') && in_array($category->id, old('categories'))) ||
                                            (isset($tour) &&
                                            $tour->categories->pluck('id')->contains($category->id)) ? 'checked' : ''
                                            }}>
                                            <label class="form-check-label" for="category_{{ $category->id }}">
                                                {{ $category->name }}
                                            </label>
                                        </div>
                                        @endforeach
                                        {{-- Categories error --}}
                                        @error('categories')
                                        @include('partials.input-validation-error-msg')
                                        @enderror
                                    </div>
                                </div>

                                {{-- Services check list --}}
                                <div class="col-12 col-md-4 my-4 overflow-scroll" style="height: 200px">
                                    <div class="position-relative">
                                        <span class="fs-3">{{ __('static.select_services') }}:</span>
                                        @foreach ($services as $service)
                                        <div class="form-check">
                                            <input type="checkbox" id="service_{{ $service->id }}" name="services[]"
                                                value="{{ $service->id }}"
                                                class="form-check-input @error('services') is-invalid @enderror" {{
                                                (old('services') && in_array($service->id, old('services'))) ||
                                            (isset($tour) &&
                                            $tour->services->pluck('id')->contains($service->id)) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="service_{{ $service->id }}">
                                                {{ $service->name }}
                                            </label>
                                        </div>
                                        @endforeach
                                        {{-- Services error --}}
                                        @error('services')
                                        @include('partials.input-validation-error-msg')
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- Price --}}
                            <div class="col-12 col-md-6 input-container">
                                <div class="position-relative">
                                    <input id="price" type="number"
                                        class="form-control @error('price') is-invalid @enderror" name="price"
                                        value="{{ old('price', $tour->price ?? '') }}" required autocomplete="price">
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

                            @if(Route::is('tours.edit') && isset($tour) && $tour->gallery->isNotEmpty())
                            <!-- Display existing images if the tour has a gallery -->
                            <div class="mb-3">
                                <label class="form-label">{{__('static.gallery_images')}}:</label>
                                <div class="d-flex flex-wrap gap-3 mb-3">
                                    @foreach($tour->gallery as $image)
                                    <div class="position-relative" style="width: 100px; height: 100px;">
                                        @if ($image->url && @get_headers($image->url))
                                        <img src="{{ $image->url }}" alt="Gallery Image"
                                            style="width:100%; height:100%; border-radius: 20px; box-shadow: 0 0 5px 5px rgba(255, 255, 255, 0.3);">
                                        @else
                                        <img src="{{ asset('storage/img/img-placeholder.png')}}" alt="Gallery Image"
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

                            {{-- Description --}}
                            <div class="col-12 col-md-10 input-container">
                                <div class="position-relative">
                                    <textarea id="description" name="description"
                                        class="form-control @error('description') is-invalid @enderror" rows="4"
                                        maxlength="500" required autocomplete="description"
                                        autofocus>{{ old('description', $tour->description ?? '') }}</textarea>
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

                            {{-- Wheelschair_accessible --}}
                            <div class="col-12 mt-3">
                                <div class="form-check">
                                    <input type="hidden" name="wheelchair_accessible" value="0">
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
                                    <input type="hidden" name="is_active" value="0">
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active"
                                        value="1" {{ old('is_active', $tour->is_active ?? false) ? 'checked' : '' }}>
                                    <label class="form-check-label text-light" for="is_active">
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

@section('add-script')
@vite(['resources/js/itinerary.js', 'resources/js/form-btn-disable.js'])
@endsection
