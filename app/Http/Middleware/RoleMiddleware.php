<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        // Verificar si el usuario tiene el rol adecuado
        if (auth()->check() && auth()->user()->role === $role) {
            return $next($request);
        }

        // Redirigir si no tiene el rol
        return redirect('/HomeUser');
    }
}
