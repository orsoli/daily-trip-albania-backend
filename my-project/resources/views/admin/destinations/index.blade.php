@extends('layouts.app')

@section('title', __('destinations.destinations_panel'). ' | ' . config('app.name'))

@section('content')
<div class="container">
    {{-- Include Notifications --}}
    @include('partials.notifications')

    {{-- Create new Destination btn --}}
    <div class="mb-4">
        <a class="btn btn-primary border rounded-5 text-secondary" data-tab='deleted_data'
            href="{{route('destinations.create')}}">{{__('destinations.create_new_destination')}}</a>
    </div>

    <div class="my-card px-2 px-md-4">
        {{-- Destinations Table header navbars --}}
        <div class="card-header">
            <div class="navbars d-flex justify-content-between mb-4">
                <ul class="nav">
                    <li class="nav-item">
                        <a class="nav-link data-nav-link text-secondary" data-tab='all_data'
                            href="{{route('destinations.index', ['with_trashed' => true])}}">{{__('destinations.all_destinations')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link data-nav-link text-secondary" data-tab='active_data'
                            href="{{route('destinations.index')}}">{{__('destinations.available_destinations')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link data-nav-link text-secondary" data-tab='deleted_data'
                            href="{{route('destinations.index',['trashed' => true])}}">{{__('destinations.deleted_destinations')}}</a>
                    </li>
                </ul>
            </div>
        </div>

        {{-- Chck if table is not empty --}}
        @if ($destinations->isNotEmpty())
        <!-- Columns Head-->
        <div class="row text-info fw-bold px-3">
            @foreach ($columns as $column)
            <div class="col {{ $column === __('static.image') ||
                                $column === __('static.country') ||
                                    $column === __('static.city') ? 'd-none d-lg-flex' : '' }}">
                {{$column}}
            </div>
            @endforeach
        </div>

        <!-- User Card -->
        <div class="row g-2 mt-2">
            @foreach ($destinations as $destination)
            <div class="col-12">
                <div class="my-card py-3">
                    <div class="card-body">
                        <div class="row align-items-center m-0">
                            {{-- Destination thumbnail --}}
                            <div class="col d-none d-lg-block">
                                @if ($destination->thumbnailExists)
                                <img src="{{ $destination->thumbnail }}" alt="{{$destination->name}}" class="thumbnail">
                                @else
                                <img src="{{ asset('storage/img/img-placeholder.png') }}" alt="{{$destination->name}}"
                                    class="thumbnail">
                                @endif
                            </div>

                            {{-- Destination name --}}
                            <div class="col fw-bold text-truncate">{{ $destination->name }}
                            </div>

                            {{-- Destinations Country --}}
                            <div class="col d-none d-lg-block">{{ $destination->country }}</div>
                            {{-- Destination city --}}
                            <div class="col d-none d-lg-block">{{ $destination->city }}</div>

                            {{-- Destinaiton price & currency --}}
                            <div class="col">{{ $destination->price }}</div>
                            <div class="col">{{ $destination->currency->code }}</div>

                            {{-- Destianation visibility --}}
                            <div class="col {{ $destination->is_visible ? 'text-success' : 'text-danger'}}">{{
                                $destination->is_visible
                                ?
                                __('static.published') :
                                __('static.unpublished') }}
                            </div>

                            {{-- Action btns --}}
                            <div class="col">
                                @if (request()->query('trashed'))
                                @include('partials.action-buttons', [
                                'isShowPage' => false,
                                'restore_href' => route('destinations.restore', $destination->id),
                                'data_name' => $destination->name,
                                'form_action' => route('destinations.forceDelete', $destination->id),
                                'modal_header' => __('static.permanently_deleting'),
                                'modal_body' => __('static.sure_to_permanently_delete')
                                ])
                                @elseif (request()->query('with_trashed'))
                                @if ($destination->deleted_at !== null)
                                <strong class=" text-danger">{{__('destinations.deleted_destinations')}}</strong>
                                @else
                                <strong class="text-success">{{__('destinations.available_destinations')}}</strong>
                                @endif
                                @else
                                @include('partials.action-buttons', [
                                'isShowPage' => false,
                                'show_href' => route('destinations.show', $destination->slug),
                                'edit_href' => route('destinations.edit', $destination->slug),
                                'data_name' => $destination->name,
                                'form_action' => route('destinations.destroy', $destination->slug),
                                'modal_header' => __('static.deleting'),
                                'modal_body' => __('static.sure_to_delete')
                                ])
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>


        <div class="mt-4">
            {{ $destinations->links('pagination::bootstrap-4') }}
        </div>
        @else

        <h1 class="text-secondary text-center py-4">{{__('static.empty')}}</h1>

        @endif
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
@if (isset($destinations) && $destinations->count() && !request()->query('with_trashed'))
@vite(['resources/js/actions-btns.js', 'resources/js/nav-tabs.js'])
@else
@vite(['resources/js/nav-tabs.js'])
@endif
@endsection

@section('add-scss')
@vite(['resources/sass/components/header-table.scss'])
@endsection
