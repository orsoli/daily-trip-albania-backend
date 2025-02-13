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
    <div class="bg-img d-flex flex-column">
        <main class="py-2 flex-grow-1 d-flex align-items-center">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12 col-lg-8">
                        <div class="card my-card">
                            {{-- Card Body --}}
                            <div class="card-body position-relative overflow-scroll">
                                <h3 class="mb-5">{{__('content.welcome_to_admin_panel')}}</h3>
                                @auth
                                <h5>
                                    <i>{{__('content.admin_panel_welcome_description')}}</i>
                                </h5>
                                <nav>
                                    <ul class="links list-unstyled d-flex justify-content-end gap-3">
                                        <li>
                                            @if (Route::has('dashboard'))
                                            <a class="btn btn-primary text-primary" href="{{ route('dashboard') }}"> Go
                                                to {{
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
                                            <a class="btn btn-primary text-info" href="{{route('login')}}">{{
                                                __('static.Login')
                                                }}</a>
                                        </li>
                                        <li>
                                            <a class="btn btn-primary text-info" href="dilytripalbania.com">{{
                                                __('static.visit_web')
                                                }}</a>
                                        </li>
                                        @endguest
                                    </ul>
                                </nav>
                            </div>
                            <div class="my-card-logo d-none d-md-block">
                                <img src="{{asset('img/DailyTrip-logo.png')}}" alt="daily-trip-logo">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        {{-- Footer --}}
        <footer class="text-center text-light py-2 mt-3">
            {{__('static.copy_right')}}
        </footer>
    </div>
</body>

</html>
