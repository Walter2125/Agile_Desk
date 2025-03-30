<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HistorialCambios;

class HistorialCambiosController extends Controller
{
    /**
     * Muestra el historial de cambios con filtros y paginación.
     */
    public function index(Request $request)
    {
        $query = HistorialCambios::query();

        if ($request->filled('usuario')) {
            $query->where('usuario', 'LIKE', '%' . $request->usuario . '%');
        }
        if ($request->filled('accion')) {
            $query->where('accion', $request->accion);
        }
        if ($request->filled('fecha')) {
            $query->whereDate('fecha', $request->fecha);
        }

        $historial = $query->orderBy('fecha', 'desc')->paginate(5);

        if ($request->ajax()) {
            return response()->json($historial);
        }

        return view('HistorialCambios')->with('historial', $historial);
    }

    /**
     * Muestra un cambio específico.
     */
    public function show($id)
    {
        $cambio = HistorialCambios::findOrFail($id);
        return view('historial.show')->with('cambio', $cambio);
    }

    /**
     * Almacena un nuevo registro de historial de cambios.
     */
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

        return redirect()->route('historialcambios.index')->with('exito', 'Cambio registrado exitosamente');
    }

    /**
     * Revertir un cambio específico.
     */
    public function revertir($id)
    {
        $cambio = HistorialCambios::findOrFail($id);

        if ($cambio->delete()) {
            return redirect()->route('historialcambios.index')->with('exito', 'Cambio revertido exitosamente');
        } else {
            return redirect()->route('historialcambios.index')->with('error', 'Error al revertir el cambio');
        }
    }
}