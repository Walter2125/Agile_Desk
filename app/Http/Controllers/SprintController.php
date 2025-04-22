<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Sprint;
use Illuminate\Http\Request;

class SprintController extends Controller
{
    /**
     * Muestra una lista de los sprints.
     */
    public function index(Request $request)
    {
        $proyectoId = $request->query('proyecto_id');
        
        // Query base
        $sprintsQuery = Sprint::with('project');
        
        // Si hay un proyecto seleccionado, filtrar por ese proyecto
        if ($proyectoId && $proyectoId != 'all') {
            $sprintsQuery->where('project_id', $proyectoId);
        }
        
        // Obtener los sprints ordenados por proyecto_id
        $sprints = $sprintsQuery->orderBy('project_id')->get();
        
        // Obtener todos los proyectos para el filtro
        $proyectos = Project::all();

        return view('Sprint.ListaSprint', compact('sprints', 'proyectos', 'proyectoId'));
    }

    /**
     * Muestra el formulario para crear un nuevo sprint.
     */
    public function create()
    {
        $projects = Project::all();

        return view('Sprint.CrearSprints', compact('projects'));
    }

    /**
     * Almacena un nuevo sprint en la base de datos.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre'       => 'required|string|max:255',
            'fecha_inicio' => 'required|date',
            'fecha_fin'    => 'required|date|after_or_equal:fecha_inicio',
            'estado'       => 'required|in:PLANEADO,EN_CURSO,FINALIZADO',
            'project_id'   => 'required|exists:nuevo_proyecto,id',
            'color'        => 'required|string',
            'tipo'         => 'required|in:NORMAL,URGENTE,BLOQUEADO',
            'descripcion'  => 'nullable|string',
            'todo_el_dia'  => 'boolean',
        ]);

        $data = $request->all();
        $data['todo_el_dia'] = $request->has('todo_el_dia');

        Sprint::create($data);

        return redirect()->route('sprints.index')
                         ->with('success', 'Sprint creado correctamente');
    }

    /**
     * Muestra el formulario para editar un sprint existente.
     */
    public function edit(Sprint $sprint)
    {
        $projects = Project::all();

        return view('Sprint.EditarSprint', compact('sprint', 'projects'));
    }

    /**
     * Actualiza un sprint en la base de datos.
     */
    public function update(Request $request, Sprint $sprint)
    {
        $request->validate([
            'nombre'       => 'required|string|max:255',
            'fecha_inicio' => 'required|date',
            'fecha_fin'    => 'required|date|after_or_equal:fecha_inicio',
            'estado'       => 'required|in:PLANEADO,EN_CURSO,FINALIZADO',
            'project_id'   => 'required|exists:nuevo_proyecto,id', 
            'color'        => 'required|string',
            'tipo'         => 'required|in:NORMAL,URGENTE,BLOQUEADO',
            'descripcion'  => 'nullable|string',
            'todo_el_dia'  => 'boolean',
        ]);

        $data = $request->all();
        $data['todo_el_dia'] = $request->has('todo_el_dia');

        $sprint->update($data);

        return redirect()->route('sprints.index')
                         ->with('success', 'Sprint actualizado correctamente');
    }

    /**
     * Elimina un sprint de la base de datos.
     */
    public function destroy(Sprint $sprint)
    {
        $sprint->delete();

        return redirect()->route('sprints.index')
                         ->with('success', 'Sprint eliminado correctamente');
    }
}
