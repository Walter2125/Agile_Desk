<?php

namespace App\Http\Controllers;

use App\Models\SprintModel;
use Illuminate\Http\Request;

class SprintController extends Controller
{
    /**
     * Muestra una lista de los sprints.
     */
    public function index()
    {
        $sprints = SprintModel::all();
        return view('ListaSprint', compact('sprints'));    }

    /**
     * Almacena un nuevo sprint en la base de datos.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'estado' => 'required|in:PLANEADO,EN CURSO,FINALIZADO',
            'proyecto_id' => 'required|exists:proyectos,id',
            'responsable' => 'required|string|max:255',
        ]);

        $sprint = SprintModel::create($request->all());

        return response()->json($sprint, 201);
    }

    /**
     * Muestra un sprint específico.
     */
    public function show($id)
    {
        $sprint = SprintModel::find($id);
        if (!$sprint) {
            return response()->json(['message' => 'Sprint no encontrado'], 404);
        }
        return response()->json($sprint);
    }

    /**
     * Actualiza un sprint en la base de datos.
     */
    public function update(Request $request, $id)
    {
        $sprint = SprintModel::find($id);
        if (!$sprint) {
            return response()->json(['message' => 'Sprint no encontrado'], 404);
        }

        $request->validate([
            'nombre' => 'sometimes|string|max:255',
            'fecha_inicio' => 'sometimes|date',
            'fecha_fin' => 'sometimes|date|after_or_equal:fecha_inicio',
            'estado' => 'sometimes|in:PLANEADO,EN CURSO,FINALIZADO',
            'proyecto_id' => 'sometimes|exists:proyectos,id',
            'responsable' => 'sometimes|string|max:255',
        ]);

        $sprint->update($request->all());

        return response()->json($sprint);
    }

    /**
     * Elimina un sprint de la base de datos.
     */
    public function destroy($id)
    {
        $sprint = SprintModel::find($id);
        if (!$sprint) {
            return response()->json(['message' => 'Sprint no encontrado'], 404);
        }
        
        $sprint->delete();
        return response()->json(['message' => 'Sprint eliminado correctamente'], 200);
    }
}
