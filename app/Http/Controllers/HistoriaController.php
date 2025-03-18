<?php

namespace App\Http\Controllers;

use App\Models\HistoriaModel;
use Illuminate\Http\Request;

class HistoriaController extends Controller
{
    /**
     * Muestra una lista de historias de usuario.
     */
    public function index()
    {
        $historias = HistoriaModel::all();
        return response()->json($historias);
    }

    /**
     * Almacena una nueva historia de usuario en la base de datos.
     */
    public function store(Request $request)
    {
        $request->validate([
            'sprint_id' => 'required|exists:sprints,id',
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
        ]);

        $historia = HistoriaModel::create($request->all());

        return response()->json($historia, 201);
    }

    /**
     * Muestra una historia de usuario específica.
     */
    public function show($id)
    {
        $historia = HistoriaModel::find($id);
        if (!$historia) {
            return response()->json(['message' => 'Historia de usuario no encontrada'], 404);
        }
        return response()->json($historia);
    }

    /**
     * Actualiza una historia de usuario en la base de datos.
     */
    public function update(Request $request, $id)
    {
        $historia = HistoriaModel::find($id);
        if (!$historia) {
            return response()->json(['message' => 'Historia de usuario no encontrada'], 404);
        }

        $request->validate([
            'sprint_id' => 'sometimes|exists:sprints,id',
            'titulo' => 'sometimes|string|max:255',
            'descripcion' => 'sometimes|string',
        ]);

        $historia->update($request->all());

        return response()->json($historia);
    }

    /**
     * Elimina una historia de usuario de la base de datos.
     */
    public function destroy($id)
    {
        $historia = HistoriaModel::find($id);
        if (!$historia) {
            return response()->json(['message' => 'Historia de usuario no encontrada'], 404);
        }

        $historia->delete();
        return response()->json(['message' => 'Historia de usuario eliminada correctamente'], 200);
    }
    public function actualizarEstado(Request $request)
    {
        // Valida los datos recibidos
        $request->validate([
            'id' => 'required|exists:historias,id',
            'estado' => 'required|string|max:255'
        ]);

        // Encuentra la historia y actualiza el estado
        $historia = Historia::find($request->id);
        $historia->estado = $request->estado; // Asegúrate de que la tabla 'historias' tenga una columna 'estado'
        $historia->save();

        return response()->json(['success' => true, 'message' => 'Estado actualizado correctamente.']);
    }

}
