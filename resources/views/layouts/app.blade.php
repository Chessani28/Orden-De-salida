<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh"
        crossorigin="anonymous">
    <link href="{{ asset('img/brand/favicons.png') }}" rel="icon" type="image/png">
    <link href="{{ asset('js/plugins/nucleo/css/nucleo.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/argon-dashboard.css?v=1.1.2') }}" rel="stylesheet" />
    <link href="{{ asset('css/colores-tabla.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/app2.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/instaladorComponent.css') }}" rel="stylesheet" />

    <link href="{{ asset('css/style.css') }}" rel="stylesheet" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Max4SO') }}</title>

    <script src="{{ asset('js/app.js') }}" defer></script>

    <link rel="dns-prefetch" href="//fonts.gstatic.com">
</head>

<body>
    <link rel="icon" href="favicon.ico" type="image/x-icon">

    <body class="">
        <nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" id="sidenav-main">
            <div class="container-fluid">
                <!-- Toggler -->
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <!-- Brand -->
                <a class="navbar-brand pt-0">
                    <img src="{{ asset('img/brand/blue.png') }}" class="navbar-brand-img" alt="...">
                </a>

                <div class="collapse navbar-collapse" id="sidenav-collapse-main">
                    <!-- Collapse header -->
                    <div class="navbar-collapse-header d-md-none">
                        <div class="row">
                            <div class="col-6 collapse-brand">
                                <a>
                                    <img src="{{ asset('img/brand/blue.png') }}">
                                </a>
                            </div>
                            <div class="col-6 collapse-close">
                                <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false"
                                    aria-label="Toggle sidenav">
                                    <span></span>
                                    <span></span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- Form -->
                    <form class="mt-4 mb-3 d-md-none">

                    </form>

                    <ul class="navbar-nav">

                        <li class="nav-item active ">
                            </a>
                        </li>
                        <li class="nav-item">
                            </a>
                        </li>
                        <li class="nav-item">
                            </a>
                        </li>
                    </ul>
                    <!-- Divider -->
                    <hr class="my-3">
                    <!-- Heading -->
                    <h6 class="navbar-heading text-muted">Paginas asociadas</h6>
                    <!-- Navigation -->
                    <ul class="navbar-nav mb-md-3">
                        <li class="nav-item">
                            <a class="nav-link" href="https://www.max4technologies.com/" target="_blank">
                                <i class="ni ni-laptop text-dark"></i> Max4 Technologies
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="https://max4solar.mx/" target="_blank">
                                <i class="ni ni-mobile-button text-dark"></i> Max4 Solar
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="https://max4rastreosatelital.com.mx/" target="_blank">
                                <i class="ni ni-delivery-fast text-dark"></i> Rastreo Satelital
                            </a>
                        </li>
                    </ul>
                    <ul class="navbar-nav">
                        <li class="nav-item active active-pro">

                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div id="content">
                            @guest
                            @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Ingresar') }}</a>
                            </li>
                            @endif
                            @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Registrar') }}</a>
                            </li>
                            @endif
                            @else
                            <li class="nav-item dropdown">

                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                            @endguest
            <main class="py-4">
                @yield('content')
            </main>
        </div>
        <script src="{{ asset('js/plugins/jquery/dist/jquery.min.js') }}"></script>

<script src="{{ asset('js/plugins/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('js/argon-dashboard.min.js?v=1.1.2') }}"></script>

<script src="{{ asset('js/plugins/chart.js/dist/Chart.min.js') }}"></script>
<script src="{{ asset('js/plugins/chart.js/dist/Chart.extension.js') }}"></script>
<script src="https://cdn.trackjs.com/agent/v3/latest/t.js"></script>
<script src="https://cdn.trackjs.com/agent/v3/latest/t.js"></script>
<script>
  window._trackJs = {
    token: "f835588344924b0aa8d1b793351f42c4"
  };
</script>
<script src="https://cdn.trackjs.com/releases/current/tracker.js"></script>

    </body>

</html>
