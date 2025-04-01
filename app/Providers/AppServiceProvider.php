<?php

namespace App\Providers;

use App\Models\Notificaciones;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Compartir notificaciones con todas las vistas
    View::composer('*', function ($view) {
        if (Auth::check()) {
            $notificaciones = Notificaciones::where('user_id', Auth::id())
                                          ->where('read', false)
                                          ->get();
            $view->with('notificaciones', $notificaciones);
        } else {
            $view->with('notificaciones', collect([])); // Para evitar errores si no está autenticado
        }
    });
        Paginator::useBootstrap();

    }
}
