<?php

namespace App\Http\Controllers;

use App\Models\TareaModel;
use Illuminate\Http\Request;

class TareaController extends Controller
{
    /**
     * Muestra una lista de tareas.
     */
    public function index()
    {
        $tareas = TareaModel::all();
        return response()->json($tareas);
    }

    /**
     * Almacena una nueva tarea en la base de datos.
     */
    public function store(Request $request)
    {
        $request->validate([
            'historia_id' => 'required|exists:historias_usuario,id',
            'titulo' => 'required|string|max:255',
            'estado' => "required|in:Activo,En Proceso,Terminado",
        ]);

        $tarea = TareaModel::create($request->all());

        return response()->json($tarea, 201);
    }

    /**
     * Muestra una tarea específica.
     */
    public function show($id)
    {
        $tarea = TareaModel::find($id);
        if (!$tarea) {
            return response()->json(['message' => 'Tarea no encontrada'], 404);
        }
        return response()->json($tarea);
    }

    /**
     * Actualiza una tarea en la base de datos.
     */
    public function update(Request $request, $id)
    {
        $tarea = TareaModel::find($id);
        if (!$tarea) {
            return response()->json(['message' => 'Tarea no encontrada'], 404);
        }

        $request->validate([
            'historia_id' => 'sometimes|exists:historias_usuario,id',
            'titulo' => 'sometimes|string|max:255',
            'estado' => "sometimes|in:Activo,En Proceso,Terminado",
        ]);

        $tarea->update($request->all());

        return response()->json($tarea);
    }

    /**
     * Elimina una tarea de la base de datos.
     */
    public function destroy($id)
    {
        $tarea = TareaModel::find($id);
        if (!$tarea) {
            return response()->json(['message' => 'Tarea no encontrada'], 404);
        }
        
        $tarea->delete();
        return response()->json(['message' => 'Tarea eliminada correctamente'], 200);
    }
}
