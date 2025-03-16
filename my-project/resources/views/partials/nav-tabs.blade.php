<div class="navbars  mb-4">
    <ul class="nav flex-nowrap text-truncate overflow-scroll">
        @foreach ($navTabs as $navTab)
        <li class="nav-item">
            <a class="nav-link data-nav-link text-secondary" data-tab='all_data'
                href="{{$navTab['href']}}">{{$navTab['title']}}</a>
        </li>
        @endforeach
    </ul>
</div>