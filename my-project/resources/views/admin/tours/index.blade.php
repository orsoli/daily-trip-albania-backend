@extends('layouts.app')

@section('title', __('tours.tours_panel'). ' | ' . config('app.name'))

@section('content')
<div class="container">

    {{-- Create new tour btn --}}
    <div class="mb-4">
        <a class="btn btn-primary border rounded-5 text-secondary" data-tab='deleted_data'
            href="{{route('tours.create')}}">{{__('tours.create_new_tour')}}</a>
    </div>

    <div class="my-card px-2 px-md-4">
        {{-- Tours Table header navbars --}}
        <div class="card-header">

            @include('partials.nav-tabs', [
            'navTabs' => [
            [
            'title' => __('tours.all_tours'),
            'href' => route('tours.index', ['with_trashed' => true])
            ],
            [
            'title' => __('tours.available_tours'),
            'href' => route('tours.index')
            ],
            [
            'title' => __('tours.deleted_tours'),
            'href' => route('tours.index',['trashed' => true])
            ]
            ],
            ])

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
                <div class="my-card py-3 table-hover">
                    <div class="card-body">
                        <div class="row align-items-center m-0">
                            <div class="col d-none d-lg-block">
                                @if($tour->thumbnail && @get_headers($tour->thumbnail))
                                <img src="{{ $tour->thumbnail }}" alt="{{$tour->title}}" class="thumbnail">
                                @else
                                <img src="{{ asset('storage/img/img-placeholder.png') }}" alt="{{$tour->title}}"
                                    class="thumbnail">
                                @endif
                            </div>
                            <div class="col fw-bold text-truncate">{{ $tour->title }}
                            </div>
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
                            <div class="col d-none d-lg-block">{{ $tour->guide->first_name ?? 'No Guide' }}</div>
                            <div class="col {{ $tour->is_active ? 'text-success' : 'text-danger'}}">{{ $tour->is_active
                                ?
                                __('static.published') :
                                __('static.unpublished') }}</div>
                            <div class="col">
                                @if (request()->query('trashed'))
                                @include('partials.action-buttons', [
                                'isShowPage' => false,
                                'restore_href' => route('tours.restore', $tour->id),
                                'data_name' => $tour->title,
                                'form_action' => route('tours.forceDelete', $tour->id),
                                'modal_header' => __('static.permanently_deleting'),
                                'modal_body' => __('static.sure_to_permanently_delete')
                                ])
                                @elseif (request()->query('with_trashed'))
                                @if ($tour->deleted_at !== null)
                                <strong class=" text-danger">{{__('tours.deleted_tours')}}</strong>
                                @else
                                <strong class="text-success">{{__('tours.available_tours')}}</strong>
                                @endif
                                @else
                                @include('partials.action-buttons', [
                                'isShowPage' => false,
                                'show_href' => route('tours.show', $tour->slug),
                                'edit_href' => route('tours.edit', $tour->slug),
                                'data_name' => $tour->title,
                                'form_action' => route('tours.destroy', $tour->slug),
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
@if (isset($tours) && $tours->count() && !request()->query('with_trashed'))
@vite(['resources/js/actions-btns.js', 'resources/js/nav-tabs.js'])
@else
@vite(['resources/js/nav-tabs.js'])
@endif
@endsection

@section('add-scss')
@vite(['resources/sass/components/header-table.scss'])
@endsection
