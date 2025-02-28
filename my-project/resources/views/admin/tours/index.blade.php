@extends('layouts.app')

@section('title', __('tours.tours_panel'). ' | ' . config('app.name'))

@section('content')
<div class="container">
    {{-- Include Notifications --}}
    @include('partials.notifications')

    <div class="my-card px-2 px-md-4">
        {{-- Tours Table header navbars --}}
        <div class="card-header">
            <div class="navbars mb-4">
                <ul class="nav">
                    <li class="nav-item">
                        <a class="nav-link data-nav-link text-secondary" data-tab='all_data'
                            href="{{route('tours.index', ['with_trashed' => true])}}">{{__('tours.all_tours')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link data-nav-link text-secondary" data-tab='active_data'
                            href="{{route('tours.index')}}">{{__('tours.available_tours')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link data-nav-link text-secondary" data-tab='deleted_data'
                            href="{{route('tours.index',['trashed' => true])}}">{{__('tours.deleted_tours')}}</a>
                    </li>
                </ul>
            </div>
        </div>

        {{-- Chck if table is not empty --}}
        @if ($tours->isNotEmpty())
        <!-- Columns Head-->
        <div class="row text-info fw-bold px-3">
            @foreach ($columns as $column)
            <div class="col {{ $column === __('static.image') ||
                                $column === __('static.region') ||
                                    $column === __('static.guide') ||
                                        $column === __('static.categories') ? 'd-none d-lg-flex' : '' }}">
                {{$column}}
            </div>
            @endforeach
        </div>

        <!-- User Card -->
        <div class="row g-2 mt-2">
            @foreach ($tours as $tour)
            <div class="col-12">
                <div class="my-card py-3">
                    <div class="card-body">
                        <div class="row align-items-center m-0">
                            <div class="col d-none d-lg-block">
                                <img src="{{ asset('img/DailyTrip-logo.png') }}" alt="">
                            </div>
                            <div class="col fw-bold">{{ $tour->title }}</div>
                            <div class="col d-none d-lg-block">
                                <ul class="list-unstyled">
                                    @foreach ($tour->categories as $category)
                                    <li>
                                        {{ $category->name}},
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="col">{{ $tour->price }}</div>
                            <div class="col">{{ $tour->currency->code }}</div>
                            <div class="col d-none d-lg-block">{{ $tour->region->name }}</div>
                            <div class="col d-none d-lg-block">{{ $tour->guide->first_name }}</div>
                            <div class="col">{{ $tour->is_active ? 'Yes' : 'No' }}</div>
                            <div class="col ">
                                @if (request()->query('trashed'))
                                @include('partials.action-buttons', [
                                'isShowPage' => false,
                                'restore_href' => route('tours.restore', $tour->slug),
                                'data_name' => $tour->title,
                                'form_action' => route('tours.forceDelete', $tour->slug),
                                'modal_header' => __('static.permanently_deleting'),
                                'modal_body' => __('static.sure_to_permanently_delete')
                                ])
                                @elseif (request()->query('with_trashed'))
                                @if ($tour->deleted_at !== null)
                                <strong class="text-danger">{{__('tours.deleted_tours')}}</strong>
                                @else
                                <strong class="text-success">{{__('tours.available_tours')}}</strong>
                                @endif
                                @else
                                @include('partials.action-buttons', [
                                'isShowPage' => false,
                                'show_href' => route('tours.show', $tour->slug),
                                'edit_href' => route('tours.edit', $tour->slug),
                                'data_name' => $tour->title,
                                'form_action' => route('tours.destroy', $tour->id),
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
            {{ $tours->links('pagination::bootstrap-4') }}
        </div>
        @else

        <h1 class="text-secondary text-center py-4">{{__('static.empty')}}</h1>

        @endif
    </div>

</div>
<!-- Modal -->
<div class="modal fade" id="deleteModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="deleteModalLabel" aria-hidden="true">
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
@if (isset($users) && $users->count() && !request()->query('with_trashed'))
@vite(['resources/js/actions-btns.js', 'resources/js/nav-tabs.js'])
@else
@vite(['resources/js/nav-tabs.js'])
@endif
@endsection

@section('add-scss')
@vite(['resources/sass/components/header-table.scss'])
@endsection
