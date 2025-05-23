@extends('layouts.app')

@section('title', $tour->title . ' | ' . config('app.name'))

@section('content')
<div class="container align-self-center">

    {{-- Go back button --}}
    @include('partials.go-back-btn', ['route' => 'tours.index'])

    {{-- Tour Details --}}
    <div class="row justify-content-center pt-5">
        <div class="col-sm-12 col-lg-7">
            <div class="card my-card">
                <div class="card-body text-center">
                    {{-- Tour logo image --}}
                    <div class="tour-logo">
                        @if($tour->thumbnail && @get_headers($tour->thumbnail))
                        <img src="{{$tour->thumbnail}}" alt="{{$tour->slug . '-image' }}" class="tour-thumbnail">
                        @else
                        <img src="{{ asset('storage/img/img-placeholder.png') }}" alt="{{$tour->title}}"
                            class="tour-thumbnail">
                        @endif
                    </div>

                    {{-- Title --}}
                    <h5 class="card-title mt-3">
                        {{$tour->title}}
                    </h5>

                    {{-- Destinations Region --}}
                    <div class="card-subtitle mb-3 text-secondary">
                        <h5> {{__('static.region')}}: {{$tour->region->name}} </h5>
                        {{-- Destinations --}}
                        @if ($tour->destinations->count() > 0)
                        <span>{{__('static.destinations')}}:</span>
                        <strong class="fs-6">
                            <ul class="list-unstyled">
                                @foreach ($tour->destinations as $destination)
                                <li>
                                    {{$destination->city}} {{$destination->country}}
                                </li>
                                @endforeach
                            </ul>
                        </strong>
                        @endif
                    </div>

                    {{-- Guide Name --}}
                    @if($tour->guide)
                    <h4 class="card-subtitle mb-3 text-secondary">
                        {{__('tours.guided_by')}} {{$tour->guide->first_name}}
                    </h4>
                    @endif

                    {{-- Action Buttons --}}
                    <div class="actions d-flex justify-content-center align-items-end gap-3 my-3">
                        @include('partials.action-buttons', [
                        'isShowPage' => true,
                        'edit_href' => route('tours.edit', $tour->slug),
                        'data_name' => $tour->title,
                        'form_action' => route('tours.destroy', $tour->slug),
                        'modal_header' => __('static.deleting'),
                        'modal_body' => __('static.sure_to_delete')
                        ])
                    </div>

                    {{-- Discription --}}
                    <p class="card-text">
                        <i>
                            {{$tour->description}}
                        </i>
                    </p>

                    <hr>

                    {{-- Tour Details --}}
                    <div class="details col-10 text-start m-auto">
                        {{-- Price --}}
                        <p class="card-subtitle fs-5">
                            <i class="bi bi-tag-fill"></i>
                            {{__('static.price')}}:
                            <strong class="text-info">
                                {{$tour->price}} {{$tour->currency->code}}
                            </strong>
                        </p>

                        <hr>

                        {{--Duration and Difficulty --}}
                        <p class="card-subtitle d-flex justify-content-between mb-1">
                            <span class="me-5">
                                <i class="bi bi-clock-fill"></i>
                                {{__('static.duration')}}
                                <strong class="text-info">
                                    {{$tour->duration}}
                                </strong>
                            </span>
                            <span>
                                <strong class="text-info">
                                    {{$tour->difficulty}}
                                </strong>
                                {{__('static.difficulty')}}
                                <i class="bi bi-speedometer"></i>
                            </span>
                        </p>

                        {{-- Featured and popularity --}}
                        <p class="card-subtitle d-flex justify-content-between mb-1">
                            <span>
                                <i class="bi bi-person-hearts"></i>
                                {{__('static.popularity')}}:
                                <strong class="text-info">
                                    {{$tour->popularity}}
                                </strong>
                            </span>
                            <span>
                                <strong class="{{ $tour->is_featured ? 'text-primary' : 'text-danger'}}">
                                    {{$tour->is_featured ? 'Yes' : __('static.is_not')}}
                                </strong>
                                {{__('static.is_featured')}}
                                <i class="bi bi-gem text-secondary"></i>
                            </span>
                        </p>

                        {{-- Vies and rating --}}
                        <p class=" card-subtitle d-flex justify-content-between mb-1">
                            <span>
                                <i class="bi bi-eye-fill"></i>
                                {{__('static.views')}}:
                                <strong class="text-info">
                                    {{$tour->view_count}}
                                </strong>
                            </span>
                            <span>

                                @include('partials.ratings', [
                                'rating' => $tour->rating
                                ])
                            </span>
                        </p>

                        {{-- Wheelchair Accessible --}}
                        <p class="card-subtitle d-flex justify-content-between mb-1">
                            <span>
                                <i class="bi bi-person-wheelchair"></i>
                                {{__('static.wheel_chair_accessible')}}:
                                <strong class="{{ $tour->wheelchair_accessible ? 'text-success' : 'text-danger'}} ">
                                    {{$tour->wheelchair_accessible ? 'YES' : 'NO'}}
                                </strong>
                            </span>
                        </p>

                        {{-- Is Active tour --}}
                        <p class="card-subtitle d-flex justify-content-between mb-1">
                            <span>
                                <i class="bi bi-globe"></i>
                                {{__('static.visible')}}:
                                <strong class="{{ $tour->is_active ? 'text-success' : 'text-danger'}}">
                                    {{$tour->is_active ? 'YES' : 'NO'}}
                                </strong>
                            </span>
                        </p>

                        <hr>

                        {{--Tour Accommodation --}}
                        @if ($tour->accommodation)
                        <p class="card-subtitle d-flex justify-content-between mb-1">
                            <span class="me-5">
                                <i class="bi bi-building-check"></i>
                                {{__('static.accommodation')}}:
                                <strong class="text-info">
                                    {{$tour->accommodation->property_name}}
                                </strong>
                            </span>
                        </p>
                        @endif

                        <hr>

                        @if ($tour->gallery->count() > 0)
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

                    {{-- Created by --}}
                    <p class="text-secondary">
                        {{__('tours.tour_created_by')}}
                        {{$tour->created_by}}
                    </p>
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
