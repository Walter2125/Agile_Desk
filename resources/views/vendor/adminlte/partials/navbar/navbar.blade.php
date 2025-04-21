@inject('layoutHelper', 'JeroenNoten\\LaravelAdminLte\\Helpers\\LayoutHelper')

<nav class="main-header navbar
    {{ config('adminlte.classes_topnav_nav', 'navbar-expand') }}
    {{ config('adminlte.classes_topnav', 'navbar-white navbar-light') }}">

    {{-- Navbar left links --}}
    <ul class="navbar-nav">
   
        {{-- Left sidebar toggler link --}}
        @include('adminlte::partials.navbar.menu-item-left-sidebar-toggler')

        {{-- Configured left links --}}
        @each('adminlte::partials.navbar.menu-item', $adminlte->menu('navbar-left'), 'item')

        {{-- Custom left links --}}
        @yield('content_top_nav_left')
    </ul>
    <ul>
       @yield('Mensaje')
    </ul>

    {{-- Navbar right links --}}
    <ul class="navbar-nav ml-auto">
        {{-- Custom right links --}}
        @yield('content_top_nav_right')

        {{-- Configured right links --}}
        @each('adminlte::partials.navbar.menu-item', $adminlte->menu('navbar-right'), 'item')

       {{-- Notificaciones --}}
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
                <i class="fas fa-bell"></i>
                <span id="notificationCount" class="badge badge-warning navbar-badge">
                    {{ auth()->check() ? $notificaciones->count() : 0 }}
                </span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <span class="dropdown-header">Notificaciones</span>
                <div class="dropdown-divider"></div>
                <div id="notificationContainer">
                    @if(auth()->check() && $notificaciones->count() > 0)
                        <ul id="notificationList" class="list-unstyled px-3">
                            @foreach($notificaciones as $notificacion)
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
                    @else
                        <p class="text-center">No hay notificaciones</p>
                    @endif
                </div>
                <div class="dropdown-divider"></div>
                @if(auth()->check() && $notificaciones->count() > 0)
                    <form action="{{ route('notificaciones.markAllAsRead') }}" method="POST">
                        @csrf
                        <button id="markAllAsRead" type="submit" class="dropdown-item dropdown-footer">
                            Marcar todas como leídas
                        </button>
                    </form>
                @endif
            </div>
        </li>

        {{-- Search form --}}

        {{-- User menu link --}}
        @if(Auth::user())
            @if(config('adminlte.usermenu_enabled'))
                @include('adminlte::partials.navbar.menu-item-dropdown-user-menu')
            @else
                @include('adminlte::partials.navbar.menu-item-logout-link')
            @endif
        @endif

        {{-- Right sidebar toggler link --}}
        @if($layoutHelper->isRightSidebarEnabled())
            @include('adminlte::partials.navbar.menu-item-right-sidebar-toggler')
        @endif

    </ul>
</nav>
<script src="{{ asset('notificaciones.js') }}"></script>