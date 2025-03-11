<ul class="list-unstyled d-flex gap-3 m-0">
    @if (isset($show_href))
    <li>
        <a href="{{ $show_href ?? '#' }}" class="text-success">
            <i class="bi bi-eye"></i>
        </a>
    </li>
    @endif
    @if (isset($edit_href))
    @if ($isShowPage)
    <li>
        <a href="{{ $edit_href ?? '#' }}" class="btn btn-warning text-light bg-transparent rounded-5 p-1 px-5 m-0">
            {{__('static.edit')}}
        </a>
    </li>
    @else
    <li>
        <a href="{{ $edit_href ?? '#' }}" class="text-warning">
            <i class="bi bi-pencil"></i>
        </a>
    </li>
    @endif
    @endif
    @if (isset($restore_href))
    <li>
        <form action="{{$restore_href}}" method="POST">
            @csrf
            <button class="btn text-warning p-0 m-0" type="submit" value="restore">
                <i class="bi bi-arrow-counterclockwise"></i>
            </button>
        </form>
    </li>
    @endif
    <li>
        <!-- Button trigger modal -->
        @if ($isShowPage)
        <button class="btn btn-danger text-light bg-transparent rounded-5 p-1 px-5 m-0" type="button"
            data-name="{{$data_name}}" data-form-action="{{$form_action}}" data-modal-header="{{$modal_header}}"
            data-modal-body="{{$modal_body}}" data-bs-toggle="modal" data-bs-target="#deleteModal">

            {{__('static.delete')}}

        </button>
        @else
        <button class="btn text-danger p-0 m-0" type="button" data-name="{{$data_name}}"
            data-form-action="{{$form_action}}" data-modal-header="{{$modal_header}}" data-modal-body="{{$modal_body}}"
            data-bs-toggle="modal" data-bs-target="#deleteModal">

            <i class="bi bi-trash3"></i>
        </button>
        @endif
    </li>
</ul>