@extends('layouts.app')

@section('title', $destination->name . ' | ' . config('app.name'))

@section('content')
<div class="container align-self-center">
    {{-- Include Notifications --}}
    @include('partials.notifications')

    {{-- Go back button --}}
    @include('partials.go-back-btn', ['route' => 'destinations.index'])

    {{-- Destination Details --}}
    <div class="row justify-content-center pt-5">
        <div class="col-sm-12 col-lg-7">
            <div class="card my-card">
                <div class="card-body text-center">
                    {{-- Destination logo image --}}
                    <div class="tour-logo">
                        @if ($destination->thumbnailExists)
                        <img src="{{$destination->thumbnail}}" alt="{{$destination->slug . '-image' }}"
                            class="tour-thumbnail">
                        @else
                        <img src="{{asset('storage/img/img-placeholder.png')}}" alt="{{$destination->slug . '-image' }}"
                            class="tour-thumbnail">
                        @endif
                    </div>

                    {{-- Title --}}
                    <h4 class="card-title mt-3">
                        {{$destination->name}}
                    </h4>

                    {{-- Destination country & city--}}
                    <h5 class="card-subtitle mb-3 text-secondary">
                        {{$destination->country}}, {{$destination->city}}
                    </h5>

                    {{-- Action Buttons --}}
                    <div class="actions d-flex justify-content-center align-items-end gap-3 my-3">
                        @include('partials.action-buttons', [
                        'isShowPage' => true,
                        'edit_href' => route('destinations.edit', $destination->slug),
                        'data_name' => $destination->name,
                        'form_action' => route('destinations.destroy', $destination->slug),
                        'modal_header' => __('static.deleting'),
                        'modal_body' => __('static.sure_to_delete')
                        ])
                    </div>

                    {{-- Discription --}}
                    <p class="card-text">
                        <i>
                            {{$destination->description}}
                        </i>
                    </p>

                    <hr>

                    {{-- destination Details --}}
                    <div class="details col-10 text-start m-auto">
                        {{-- Price --}}
                        <p class="card-subtitle fs-5">
                            <i class="bi bi-tag-fill"></i>
                            {{__('static.price')}}:
                            <strong class="text-info">
                                {{$destination->price}} {{$destination->currency->code}}
                            </strong>
                        </p>

                        <hr>

                        {{--Destination nearest airport --}}
                        <p class="card-subtitle d-flex justify-content-between mb-1">
                            <span class="me-5">
                                <i class="bi bi-airplane-fill"></i>
                                {{__('static.nearest_airport')}}:
                                <strong class="text-info">
                                    {{$destination->nearest_airport}}
                                </strong>
                            </span>
                        </p>

                        {{--Destination Accommodation --}}
                        @if ($destination->accommodations->count() > 0)
                        <p class="card-subtitle d-flex justify-content-between mb-1">
                            <span class="me-5">
                                <i class="bi bi-building-check"></i>
                                {{__('static.accommodations')}}:
                                @foreach ($destination->accommodations as $accommodation)
                                <strong class="text-info">
                                    {{$accommodation->property_name}}
                                </strong>
                                @endforeach
                            </span>
                        </p>
                        @endif

                        {{-- Is visible destination --}}
                        <p class="card-subtitle d-flex justify-content-between mb-1">
                            <span>
                                <i class="bi bi-globe"></i>
                                {{__('static.visible')}}:
                                <strong class="{{ $destination->is_active ? 'text-success' : 'text-danger'}}">
                                    {{$destination->is_active ? 'YES' : 'NO'}}
                                </strong>
                            </span>
                        </p>

                        @if ($destination->gallery->count() > 0)
                        <!-- Display existing images if the destination has a gallery -->
                        <div class="mb-3">
                            <label class="form-label">{{__('static.gallery_images')}}:</label>
                            <div class="d-flex flex-wrap gap-3 mb-3">
                                @foreach($destination->gallery as $image)
                                <div class="position-relative" style="width: 100px; height: 100px;">
                                    @if($image->urlExists)
                                    <img src="{{ $image->url }}" alt="Gallery Image"
                                        style="width:100%; height:100%; border-radius: 20px; box-shadow: 0 0 5px 5px rgba(255, 255, 255, 0.3);">
                                    @else
                                    <img src="{{ asset('storage/img/img-placeholder.png') }}" alt="Gallery Image"
                                        style="width:100%; height:100%; border-radius: 20px; box-shadow: 0 0 5px 5px rgba(255, 255, 255, 0.3);">
                                    @endif
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                    </div>

                    {{-- logo --}}
                    <div class="logo w-25 m-auto">
                        <img src="{{asset('storage/img/DailyTrip-logo.png')}}" alt="daily-trip-logo">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Deleting Modal -->
<div class="modal fade" id="deleteModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="deleteModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-light bg-danger">
                <h1 class="modal-title fs-5" id="deleteModalLabel"></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="deleteModalBody"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                <form action="" method="POST" id="deleteForm">
                    @csrf
                    @method('DELETE')

                    <button class="btn btn-danger" type="submit" value="delete">
                        Yes, Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('add-script')
@vite(['resources/js/actions-btns.js'])
@endsection
