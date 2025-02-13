<ul class="list-unstyled d-flex gap-3 m-0">
    @if (isset($show_href))
    <li>
        <a href="{{ $show_href ?? '#' }}" class="text-success">
            <i class="bi bi-eye"></i>
        </a>
    </li>
    @endif
    @if (isset($edit_href))
    <li>
        <a href="{{ $edit_href ?? '#' }}" class="text-warning">
            <i class="bi bi-pencil"></i>
        </a>
    </li>
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
        {{-- Delete Modal --}}
        <!-- Button trigger modal -->
        <button class="btn text-danger p-0 m-0" type="button" data-user-name="{{$user_name}}"
            data-form-action="{{$form_action}}" data-modal-header="{{$modal_header}}" data-modal-body="{{$modal_body}}"
            data-bs-toggle="modal" data-bs-target="#deleteModal">

            <i class="bi bi-trash3"></i>
        </button>

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
    </li>
</ul>
