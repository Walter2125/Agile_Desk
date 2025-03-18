<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HistorialCambios;


class HistorialCambiosController extends Controller
{
    public function index(Request $request)
    {
        $query = HistorialCambios::query();

        // Filtrado
        if ($request->filled('usuario')) {
            $query->where('usuario', 'like', '%' . $request->usuario . '%');
        }
        if ($request->filled('accion')) {
            $query->where('accion', $request->accion);
        }
        if ($request->filled('fecha')) {
            $query->whereDate('fecha', $request->fecha);
        }

        // Paginación
        $historial = $query->paginate(10);

        return response()->json($historial);
    }

    public function revertir($id)
    {
        $cambio = HistorialCambio::find($id);

        if ($cambio) {
            // Lógica para revertir el cambio (dependiendo de tu modelo de datos)
            // Ejemplo: Deshacer una edición, restaurar un registro eliminado, etc.
            $cambio->revertir(); // Método ficticio para revertir el cambio
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 404);
    }
}
