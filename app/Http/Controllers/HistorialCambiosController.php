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

        // Filtros
        if ($request->filled('usuario')) {
            $query->where('usuario', 'like', '%' . $request->usuario . '%');
        }

        if ($request->filled('accion')) {
            $query->where('accion', $request->accion);
        }

        if ($request->filled('fecha')) {
            $query->whereDate('fecha', $request->fecha);
        }

        if ($request->filled('sprint')) {
            $query->where('sprint', $request->sprint);
        }

        $historial = $query->orderBy('fecha', 'desc')->paginate(10);


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
    // Validar los datos si es necesario
    $request->validate([
        'usuario' => 'required|string|max:255',
        'accion' => 'required|string|max:255',
        'detalles' => 'required|string|max:1000',
        'sprint' => 'required|integer',  // Asegúrate de validar sprint como número
        'fecha' => 'required|date',
    ]);

    // Crear una nueva entrada en la base de datos
    HistorialCambio::create([
        'usuario' => $request->usuario,
        'accion' => $request->accion,
        'detalles' => $request->detalles,
        'sprint' => $request->sprint,  // Guardar el valor de sprint
        'fecha' => $request->fecha,
    ]);

    // Redirigir o mostrar mensaje
    return redirect()->route('historialcambios.index')->with('success', 'Cambio registrado con éxito');
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