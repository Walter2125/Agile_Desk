<?php

namespace App\Http\Controllers;

use App\Models\Notificaciones;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class NotificacionesController extends Controller
{
    public function __construct()
    {
        // Compartir notificaciones en todas las vistas
        View::composer('*', function ($view) {
            if (auth()->check()) {
                $notificaciones = Notificaciones::where('user_id', auth()->id())
                    ->where('read', false)
                    ->orderBy('created_at', 'desc')
                    ->get();
                
                $view->with('notificaciones', $notificaciones);
            }
        });
    }

    public function index()
    {
        $notificaciones = Notificaciones::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();
        
        if (request()->wantsJson()) {
            return response()->json($notificaciones);
        }
        
        return view('Notificaciones', compact('notificaciones'));
    }

    public function markAsRead($id)
    {
        $notificacion = Notificaciones::findOrFail($id);
        
        // Check authorization
        if ($notificacion->user_id !== auth()->id()) {
            return redirect()->back()->with('error', 'No tienes permiso para realizar esta acción.');
        }
        
        $notificacion->update(['read' => true]);
        
        if (request()->wantsJson()) {
            return response()->json(['success' => true]);
        }
        
        return redirect()->back()->with('success', 'Notificación marcada como leída.');
    }

    public function markAllAsRead()
    {
        Notificaciones::where('user_id', auth()->id())
            ->where('read', false)
            ->update(['read' => true]);
        
        if (request()->wantsJson()) {
            return response()->json(['success' => true]);
        }
        
        return redirect()->back()->with('success', 'Todas las notificaciones han sido marcadas como leídas.');
    }

    public function destroy($id)
    {
        $notificacion = Notificaciones::findOrFail($id);
        
        // Check authorization
        if ($notificacion->user_id !== auth()->id()) {
            return redirect()->back()->with('error', 'No tienes permiso para realizar esta acción.');
        }
        
        $notificacion->delete();
        
        if (request()->wantsJson()) {
            return response()->json(['success' => true]);
        }
        
        return redirect()->back()->with('success', 'Notificación eliminada.');
    }
}
