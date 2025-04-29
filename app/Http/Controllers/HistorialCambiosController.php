<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HistorialCambios;
use App\Models\Project;


class HistorialCambiosController extends Controller
{
    /**
     * Muestra el historial de cambios con filtros y paginación.
     */
    public function index(Project $project, Request $request)
{
    $query = HistorialCambios::where('project_id', $project->id);

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

    return view('HistorialCambios', [
        'historial' => $historial,
        'project' => $project,
    ]);
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
        'usuario'    => 'required|string|max:255',
        'accion'     => 'required|string|max:255',
        'detalles'   => 'required|string|max:1000',
        'sprint'     => 'required|integer',
        'fecha'      => 'required|date',
        'project_id' => 'required|exists:nuevo_proyecto,id', // Validamos que exista el proyecto
    ]);

    // Crear una nueva entrada en la base de datos
    HistorialCambios::create([
        'usuario'    => $request->usuario,
        'accion'     => $request->accion,
        'detalles'   => $request->detalles,
        'sprint'     => $request->sprint,
        'fecha'      => $request->fecha,
        'project_id' => $request->project_id,
    ]);

    // Redirigir o mostrar mensaje
    return redirect()->route('historialcambios.index')->with('success', 'Cambio registrado con éxito');
}

}