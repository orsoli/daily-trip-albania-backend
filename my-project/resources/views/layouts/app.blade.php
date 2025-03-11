<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="robots" content="index, follow">
    <meta name="description" content="{{ config('app.name')}}">
    <meta name="author" content="Orsol Filaj">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" href="{{ asset('storage/img/DailyTrip-logo.png') }}" type="image/png">

    <title>@yield('title')</title>

    <!-- Fonts -->

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js', 'resources/js/toast-notification.js'])
</head>

<body>
    <div id="app">
        <div class="bg-img d-flex flex-column overflow-scroll">
            {{-- Header Nav bars --}}
            <header class="position-sticky bg-transparent top-0 z-1" style="transition: background-color 0.5s;">
                <nav class="navbar navbar-expand-md text-light bg-primary">
                    <div class="container">
                        <div class="d-flex justify-content-between align-items-center w-100">
                            <!-- BurgerMenu Button -->
                            <button class="navbar-toggler filter-invert border-0" type="button" data-bs-toggle="modal"
                                data-bs-target="#burgerMenuModal">
                                <span class="navbar-toggler-icon"></span>
                            </button>

                            {{-- App logo and container --}}
                            <div class="d-flex align-items-center">
                                {{-- App Logo --}}
                                <div class="header-logo m-0" style="width: 70px;">
                                    <a class="navbar-brand" href="{{ url('/') }}">
                                        <img src="{{ asset('storage/img/DailyTrip-logo.png') }}"
                                            alt="daily-trip-albania-logo">
                                    </a>
                                </div>
                                {{-- Left Side of Navbars --}}
                                <nav class="nav d-none d-md-block ms-2">
                                    @auth
                                    @if (Auth::user()->hasVerifiedEmail())
                                    <ul class="list-unstyled d-flex m-0">
                                        <li>
                                            <a href="{{route('dashboard')}}" class="nav-link text-light">
                                                {{__('static.dashboard')}}
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{route('tours.index')}}" class="nav-link text-light">
                                                {{__('static.tours')}}
                                            </a>
                                        </li>
                                        @if(Auth::user()->role->name
                                        ===
                                        'Super Admin')
                                        <li>
                                            <a data-tab="active_users" href="{{route('user.index')}}"
                                                class="nav-link text-light">
                                                {{__('static.users')}} </a>
                                        </li>
                                        <li>
                                            <a data-tab="active_users" href="{{route('roles.index')}}"
                                                class="nav-link text-light">
                                                {{__('static.roles')}} </a>
                                        </li>
                                        @endif
                                    </ul>
                                    @endif
                                    @endauth
                                </nav>
                            </div>

                            <!-- Right Side Of Navbars -->
                            <div>
                                <ul class="navbar-nav ms-auto">
                                    <!-- Authentication Links -->
                                    @guest
                                    @if (Route::has('login'))
                                    <li class="nav-item">
                                        <a class="nav-link text-light fs-5" href="{{ route('login') }}">
                                            {{ __('static.Login')}}
                                        </a>
                                    </li>
                                    @endif
                                    @else
                                    {{-- Auth UserName profile --}}
                                    @if (Route::has('register') && Auth::user()->hasVerifiedEmail() &&
                                    Auth::user()->role->name
                                    ===
                                    'Super Admin')
                                    {{-- Add Section --}}
                                    <li class="nav-item dropdown d-none d-md-flex align-self-center">
                                        <a id="navbarDropdown" class="nav-link text-light dropdown-toggle h-100"
                                            href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false" v-pre>
                                            {{__('static.add')}}
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end my-card"
                                            aria-labelledby="navbarDropdown">
                                            <ul class="list-unstyled">
                                                <li>
                                                    <a class="nav-link text-secondary" href="{{ route('register') }}">
                                                        <i class="bi bi-plus-circle-dotted"></i>
                                                        {{ __('static.addUser') }}
                                                    </a>

                                                </li>
                                                <li>
                                                    <a class="nav-link text-secondary"
                                                        href="{{ route('roles.create') }}">
                                                        <i class="bi bi-plus-circle-dotted"></i>
                                                        {{ __('static.addRole') }}
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="nav-link text-secondary"
                                                        href="{{ route('tours.create') }}">
                                                        <i class="bi bi-plus-circle-dotted"></i>
                                                        {{ __('tours.add_tour') }}
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                    @endif
                                    {{-- Auth User Profile --}}
                                    <li class="nav-item dropdown justify-content-center">
                                        <a id="navbarDropdown" class="nav-link dropdown-toggle text-light fs-6 fs-md-5"
                                            href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false" v-pre>
                                            <img src="{{ asset('storage/img/user.png') }}" alt="user-img"
                                                class="rounded-circle bg-light bg-opacity-50 filter-invert p-1 m-1"
                                                width="30" height="30">
                                            <span class="d-none d-md-inline">
                                                {{ Auth::user()->first_name }} {{ Auth::user()->last_name}}
                                            </span>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end my-card position-absolute"
                                            aria-labelledby="navbarDropdown">
                                            <ul class="list-unstyled">
                                                <li>
                                                    <a class="dropdown-item text-secondary"
                                                        href="{{route('user.show', Auth::user())}}">
                                                        <i class="bi bi-person-circle"></i> {{ __('static.my_profile')
                                                        }}
                                                    </a>
                                                </li>
                                                @if (Auth::user()->role->slug === 'super-admin')
                                                <li>
                                                    <a class="dropdown-item text-secondary" data-tab="deleted_users"
                                                        href="{{route('user.index',['trashed' => true,])}}">
                                                        <i class="bi bi-trash3-fill"></i> {{ __('static.trash') }}
                                                    </a>
                                                </li>
                                                @endif
                                                <li class="my-2">
                                                    <a class="dropdown-item text-secondary" href="{{ route('logout') }}"
                                                        onclick="event.preventDefault();
                                                                         document.getElementById('logout-form').submit();">
                                                        <i class="bi bi-box-arrow-left"></i> {{ __('static.Logout') }}
                                                    </a>
                                                </li>
                                            </ul>

                                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                class="d-none">
                                                @csrf
                                            </form>
                                        </div>
                                    </li>
                                    @endguest
                                </ul>
                            </div>
                        </div>
                    </div>
                </nav>
            </header>

            <!-- BurgerMenu Modal -->
            <div class="modal fade my-card w-50 my-2" id="burgerMenuModal" tabindex="-1"
                aria-labelledby="burgerMenuModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content bg-transparent">
                        <!-- Close Button -->
                        <button type="button" class="btn-close filter-invert position-absolute top-0 end-0 m-3"
                            data-bs-dismiss="modal" aria-label="Close"></button>

                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h5 class="modal-title">Menu</h5>
                        </div>

                        @auth
                        <!-- Modal Body -->
                        <div class="modal-body">
                            <div>
                                <ul class="navbar-nav">
                                    @auth
                                    @if (Auth::user()->hasVerifiedEmail())
                                    <ul class="list-unstyled d-flex flex-column flex-md-row m-0">
                                        <li>
                                            <a href="{{route('dashboard')}}" class="nav-link text-secondary">
                                                <i class="bi bi-house-door"></i>
                                                {{__('static.dashboard')}}
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{route('tours.index')}}" class="nav-link text-secondary">
                                                <i class="bi bi-person-walking"></i>
                                                {{__('static.tours')}}
                                            </a>
                                        </li>
                                        @if(Auth::user()->role->name
                                        ===
                                        'Super Admin')
                                        <li>
                                            <a data-tab="active_users" href="{{route('user.index')}}"
                                                class="nav-link text-secondary">
                                                <i class="bi bi-people-fill"></i>
                                                {{__('static.users')}} </a>
                                        </li>
                                        <li>
                                            <a data-tab="active_users" href="{{route('roles.index')}}"
                                                class="nav-link text-secondary">
                                                <i class="bi bi-person-fill-gear"></i>
                                                {{__('static.roles')}} </a>
                                        </li>
                                        @endif
                                    </ul>
                                    @endif
                                    @endauth
                                </ul>
                            </div>
                            <div class="my-3">
                                {{__('static.add')}}
                                <hr>
                                <ul class="navbar-nav">
                                    @if (Route::has('register') && Auth::user()->hasVerifiedEmail() &&
                                    Auth::user()->role->name
                                    ===
                                    'Super Admin')
                                    <li>
                                        <a class="nav-link text-secondary" href="{{ route('register') }}">
                                            <i class="bi bi-person-plus"></i>
                                            {{ __('static.addUser') }}
                                        </a>
                                    </li>
                                    <li>
                                        <a class="nav-link text-secondary" href="{{ route('roles.create') }}">
                                            <i class="bi bi-person-plus"></i>
                                            {{ __('static.addRole') }}
                                        </a>
                                    </li>
                                    @endif
                                    <li>
                                        <a class="nav-link text-secondary" href="{{ route('tours.create') }}">
                                            <i class="bi bi-plus"></i>
                                            {{ __('tours.add_tour') }}
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        @endauth
                    </div>
                </div>
            </div>
            {{-- End BurgerMenu Modal --}}

            {{-- Main --}}
            <main class="flex-grow-1 d-flex py-3">
                {{-- Main content --}}
                @yield('content')
            </main>

            {{-- Footer --}}
            <footer class="text-center text-light p-5">
                {{__('static.copy_right')}}
            </footer>
        </div>
    </div>
    @yield('add-script')
    @yield('add-scss')
</body>

</html>
