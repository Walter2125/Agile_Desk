<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HistorialCambios;


class HistorialCambiosController extends Controller
{
    // Obtener historial con filtros y paginación
    public function index(Request $request)
    {
        $query = HistorialCambios::query();

        if ($request->has('usuario')) {
            $query->where('usuario', 'LIKE', '%' . $request->usuario . '%');
        }
        if ($request->has('accion')) {
            $query->where('accion', $request->accion);
        }
        if ($request->has('fecha')) {
            $query->whereDate('fecha', $request->fecha);
        }

        $historial = $query->orderBy('fecha', 'desc')->paginate(10);

        return response()->json($historial);
    }

    // Registrar un nuevo cambio
    public function store(Request $request)
    {
        $request->validate([
            'usuario' => 'required|string',
            'accion' => 'required|string',
            'detalles' => 'required|string',
        ]);

        HistorialCambios::create([
            'fecha' => now(),
            'usuario' => $request->usuario,
            'accion' => $request->accion,
            'detalles' => $request->detalles,
        ]);

        return response()->json(['success' => true, 'message' => 'Cambio registrado']);
    }

    // Revertir un cambio
    public function revertir($id)
    {
        $cambio = HistorialCambios::find($id);

        if (!$cambio) {
            return response()->json(['success' => false, 'message' => 'Cambio no encontrado'], 404);
        }

        // Lógica de reversión (ejemplo: restaurar valores previos si se tiene un backup)
        // Aquí solo eliminamos el registro como ejemplo
        $cambio->delete();

        return response()->json(['success' => true, 'message' => 'Cambio revertido']);
    }
}
