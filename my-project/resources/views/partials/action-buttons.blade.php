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
        <form action="{{ $destroy_action ?? '#' }}" method="POST">
            @csrf
            @method('DELETE')

            <button class="btn text-danger p-0 m-0" type="submit" value="delete">
                <i class="bi bi-trash3"></i>
            </button>
        </form>
    </li>
</ul>
