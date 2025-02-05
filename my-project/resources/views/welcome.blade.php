<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="robots" content="index, follow">
    <meta name="description" content="Welcome in administration page of Daily Trip Albania">
    <meta name="author" content="Orsol Filaj">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- links --}}
    <link rel="icon" href="/img/DailyTrip-logo.png" type="image/png">
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <title>{{__('static.admin_panel')}} | {{config('app.name')}}</title>
</head>

<body>
    <main class="mb-3 p-3">
        <div class="container body-gb">
            <div class="logo col-12 d-flex justify-content-center mb-5">
                <img src="{{asset('img/DailyTrip-logo.png')}}" alt="daily-trip-logo"
                    class="col-3 bg-secondary rounded-5 shadow">
            </div>
            <div class="row justify-content-center mb-3">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h3>{{__('content.welcome_to_admin_panel')}}</h3>
                        </div>
                        {{-- Card Body --}}
                        <div class="card-body">
                            @auth
                            <h5>
                                <i>{{__('content.admin_panel_welcome_description')}}</i>
                            </h5>
                            <nav>
                                <ul class="links list-unstyled d-flex justify-content-end gap-3">
                                    <li>
                                        @if (Route::has('dashboard'))
                                        <a class="nav-link text-info" href="{{ route('dashboard') }}"> Go to {{
                                            __('static.dashboard')
                                            }}</a>
                                        @endif
                                    </li>
                                </ul>
                            </nav>
                            @endauth
                            @guest
                            <h5>
                                <i>{{__('content.guest_welcome_description')}}</i>
                            </h5>
                            <nav>
                                <ul class="links list-unstyled d-flex justify-content-end gap-3">
                                    <li>
                                        <a class="nav-link text-info" href="{{route('login')}}">{{
                                            __('static.Login')
                                            }}</a>
                                    </li>
                                    <li>
                                        <a class="nav-link text-info" href="dilytripalbania.com">{{
                                            __('static.visit_web')
                                            }}</a>
                                    </li>
                                    @endguest
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    {{-- Footer --}}
    <footer class="text-center py-2 mt-3">
        {{__('static.copy_right')}}
    </footer>

</body>

</html>
