<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sprint;
use Illuminate\Support\Facades\Log;

class FullCalendarController extends Controller
{
    public function index()
    {
        return view('fullcalendar');
    }

    public function ajax(Request $request)
    {
        $sprints = Sprint::all()->map(function ($sprint) {
            return [
                'id' => $sprint->id,
                'title' => $sprint->nombre,
                'start' => $sprint->fecha_inicio,
                'end' => $sprint->fecha_fin,
                'allDay' => $sprint->todo_el_dia,
                'color' => $sprint->color,
                'extendedProps' => [
                    'description' => $sprint->descripcion,
                    'tipo' => $sprint->tipo
                ]
            ];
        });

        return response()->json($sprints);
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'start' => 'required|date',
                'end' => 'required|date|after_or_equal:start',
                'color' => 'required|string',
                'tipo' => 'required|string',
                'description' => 'nullable|string',
                'todo_el_dia' => 'required|boolean',
                'proyecto_id' => 'nullable|exists:proyectos,id'
            ]);

            $sprint = Sprint::create([
                'nombre' => $validatedData['title'],
                'fecha_inicio' => $validatedData['start'],
                'fecha_fin' => $validatedData['end'],
                'estado' => 'nuevo',
                'color' => $validatedData['color'],
                'tipo' => $validatedData['tipo'],
                'descripcion' => $validatedData['description'],
                'todo_el_dia' => $validatedData['todo_el_dia'],
                'proyecto_id' => $validatedData['proyecto_id'] ?? null
            ]);

            return response()->json([
                'success' => true,
                'data' => $sprint
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error al crear sprint: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error interno del servidor'
            ], 500);
        }
    }

    public function destroy(string $id)
    {
        try {
            $sprint = Sprint::findOrFail($id);
            $sprint->delete();
    
            return response()->json([
                'success' => true,
                'message' => 'Evento eliminado permanentemente'
            ]);
    
        } catch (\Exception $e) {
            Log::error('Error al eliminar sprint: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el evento'
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $sprint = Sprint::findOrFail($id);
            
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'start' => 'required|date',
                'end' => 'required|date|after_or_equal:start',
                'color' => 'required|string',
                'tipo' => 'required|string',
                'description' => 'nullable|string',
                'todo_el_dia' => 'boolean'
            ]);
            
            $sprint->update([
                'nombre' => $validatedData['title'],
                'fecha_inicio' => $validatedData['start'],
                'fecha_fin' => $validatedData['end'],
                'color' => $validatedData['color'],
                'tipo' => $validatedData['tipo'],
                'descripcion' => $validatedData['description'],
                'todo_el_dia' => $validatedData['todo_el_dia'] ?? $sprint->todo_el_dia
            ]);
            
            return response()->json([
                'success' => true,
                'data' => $sprint
            ]);
        } catch (\Exception $e) {
            Log::error('Error al actualizar sprint: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el evento'
            ], 500);
        }
    }
}