<?php

namespace App\Http\Controllers;

use App\Models\Sprint;
use App\Models\Project;
use App\Models\Tablero;
use Illuminate\Http\Request;

class SprintController extends Controller
{
    public function create()
    {
        $projects = Project::all(); // Obtener todos los proyectos para el select
        return view('Sprint.CrearSprints', compact('projects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after:fecha_inicio',
            'color' => 'required|string|max:7',
            'project_id' => 'required|exists:nuevo_proyecto,id'
        ]);

        // Verificar duplicados
        $existingSprint = Sprint::where('project_id', $request->project_id)
            ->where('nombre', $request->nombre)
            ->first();

        if ($existingSprint) {
            return redirect()->back()
                ->with('error', 'Ya existe un sprint con este nombre en este proyecto');
        }

        $sprint = Sprint::create($request->all());
        return redirect()->route('tableros.show', $sprint->project->tablero->id)
            ->with('success', 'Sprint creado correctamente');
    }

    public function edit($id)
    {
        $sprint = Sprint::findOrFail($id);
        $projects = Project::all(); // Para el select de proyectos
        return view('Sprint.EditarSprint', compact('sprint', 'projects'));
    }

    public function update(Request $request, $id)
    {
        $sprint = Sprint::findOrFail($id);
        
        $request->validate([
            'nombre' => 'required|string|max:255',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after:fecha_inicio',
            'color' => 'required|string|max:7'
        ]);

        $sprint->update($request->all());
        
        return redirect()->route('tablero.show', $sprint->project->tablero->id)
            ->with('success', 'Sprint actualizado correctamente');
    }

    public function destroy($id)
    {
        $sprint = Sprint::findOrFail($id);
        $tableroId = $sprint->project->tablero->id;
        
        $sprint->delete();
        
        return redirect()->route('tableros.show', $tableroId)
            ->with('success', 'Sprint eliminado correctamente');
    }

    public function show($id)
    {
        $sprint = Sprint::with(['historias', 'project.tablero'])->findOrFail($id);
       /* $tablero = $sprint->project->tablero;
        $tablero = Tablero::with('project')->find($id);
        */
        $tablero = Tablero::with(['columnas', 'columnas.historias'])->find($id);
        $sprints = $sprint->project->sprints; // Obtener todos los sprints del proyecto
        $tablero = $sprint->project->tablero; // Obtener el tablero relacionado con el proyecto
        $sprints = $sprint->project->sprints; 
        return view('TableroSprints', [
            'sprint' => $sprint,
            'tablero' => $tablero,
            'sprints' => $sprints
        ]);
    }
}
