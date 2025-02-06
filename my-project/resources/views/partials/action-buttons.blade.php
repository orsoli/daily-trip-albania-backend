<ul class="list-unstyled d-flex gap-3">
    <li>
        <a href="{{ $show_href ?? '#' }}">
            <i class="bi bi-eye"></i>
        </a>

        {{--
        <!-- Button trigger modal -->
        <button type="button" class="btn p-0 text-primary" data-bs-toggle="modal" data-bs-target="#myModal">
            <i class="bi bi-eye"></i>
        </button>

        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-secondary">
                        <h1 class="modal-title fs-5" id="myModalLabel"> {{$user->first_name}} {{$user->last_name}} </h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        ...
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div> --}}
    </li>
    <li>
        <a href="{{ $edit_href ?? '#' }}" class="text-warning">
            <i class="bi bi-pencil"></i>
        </a>
    </li>
    <li>
        <a href="{{ $delete_href ?? '#' }}" class="text-danger">
            <i class="bi bi-trash3"></i>
        </a>
    </li>
</ul>