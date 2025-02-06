<ul class="list-unstyled d-flex gap-3">
    <li>
        <a href="{{ $show_href ?? '#' }}">
            <i class="bi bi-eye"></i>
        </a>
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