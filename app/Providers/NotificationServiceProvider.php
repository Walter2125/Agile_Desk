<?php

namespace App\Providers;

use App\Models\Notificaciones;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class NotificationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            if (Auth::check()) {
                $notificaciones = Notificaciones::where('user_id', Auth::id())
                    ->where('read', false)
                    ->orderBy('created_at', 'desc')
                    ->get();
                
                $view->with('notificaciones', $notificaciones);
            }
        });
    }
}