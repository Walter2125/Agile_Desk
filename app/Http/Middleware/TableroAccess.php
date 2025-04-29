<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Tablero;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TableroAccess
{
    public function handle(Request $request, Closure $next)
    {
        $tableroId = $request->route('tablero') ?? $request->route('id');
        
        if (!$tableroId) {
            return redirect()->route('projects.my')
                ->with('error', 'Tablero no especificado.');
        }
        
        $tablero = Tablero::find($tableroId);
        
        if (!$tablero) {
            return redirect()->route('projects.my')
                ->with('error', 'Tablero no encontrado.');
        }
        
        if (!$tablero->proyecto) {
            return redirect()->route('projects.my')
                ->with('error', 'Este tablero no está asociado a ningún proyecto.');
        }
        
        if (!Auth::user()->projects->contains($tablero->proyecto->id)) {
            return redirect()->route('projects.my')
                ->with('error', 'No tienes acceso a este tablero.');
        }
        
        return $next($request);
    }
}