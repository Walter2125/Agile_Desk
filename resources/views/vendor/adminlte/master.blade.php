<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="dark">

<head>

    {{-- Base Meta Tags --}}
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Custom Meta Tags --}}
    @yield('meta_tags')

    {{-- Title --}}
    <title>
        @yield('title_prefix', config('adminlte.title_prefix', ''))
        @yield('title', config('adminlte.title', 'AdminLTE 3'))
        @yield('title_postfix', config('adminlte.title_postfix', ''))
    </title>

    {{-- Icono --}}
    <link rel="icon" href="{{ asset('img/newlogo.png') }}" type="image/x-icon">

    {{-- Custom stylesheets (pre AdminLTE) --}}
    @yield('adminlte_css_pre')

    {{-- Base Stylesheets --}}
    @if(config('adminlte.enabled_laravel_mix', false))
        <link rel="stylesheet" href="{{ mix(config('adminlte.laravel_mix_css_path', 'css/app.css')) }}">
    @else
        <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">

        @if(config('adminlte.google_fonts.allowed', true))
            <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
        @endif
    @endif

    {{-- Extra Configured Plugins Stylesheets --}}
    @include('adminlte::plugins', ['type' => 'css'])

    {{-- Livewire Styles --}}
    @if(config('adminlte.livewire'))
        @livewireStyles
    @endif

    {{-- Custom Stylesheets (post AdminLTE) --}}
    @yield('adminlte_css')

</head>

<body class="@yield('classes_body')" @yield('body_data')>

    {{-- Body Content --}}
    @yield('body')

    {{-- Base Scripts --}}
    @if(config('adminlte.enabled_laravel_mix', false))
        <script src="{{ mix(config('adminlte.laravel_mix_js_path', 'js/app.js')) }}"></script>
    @else
        <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('vendor/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
        <script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
    @endif

    {{-- Extra Configured Plugins Scripts --}}
    @include('adminlte::plugins', ['type' => 'js'])

    {{-- Livewire Script --}}
    @if(config('adminlte.livewire'))
        @livewireScripts
    @endif

    {{-- Custom Scripts --}}
    @yield('adminlte_js')

    {{-- Script de Notificaciones --}}
    @if(auth()->check())
        <div class="dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="notificacionesDropdown" role="button" data-toggle="dropdown">
                <i class="far fa-bell"></i>
                <span id="notificationCount" class="badge badge-warning navbar-badge">
                    {{ $notificaciones->count() ?? 0 }}
                </span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <span class="dropdown-header">Notificaciones</span>
                <div class="dropdown-divider"></div>
                <div id="notificationContainer">
                    <ul id="notificationList" class="list-unstyled px-3">
                        @foreach($notificaciones ?? collect() as $notificacion)
                            <li>
                                <form action="{{ route('notificaciones.markAsRead', $notificacion->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <div class="media">
                                            <div class="media-body">
                                                <h3 class="dropdown-item-title">{{ $notificacion->title }}</h3>
                                                <p class="text-sm">{{ $notificacion->message }}</p>
                                            </div>
                                        </div>
                                    </button>
                                </form>
                                <div class="dropdown-divider"></div>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="dropdown-divider"></div>
                <form action="{{ route('notificaciones.markAllAsRead') }}" method="POST">
                    @csrf
                    <button type="submit" class="dropdown-item dropdown-footer">
                        Marcar todas como leídas
                    </button>
                </form>
            </div>
        </div>
    @endif

</body>
</html>
