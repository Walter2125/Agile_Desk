<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    // Mostrar formulario de creación de proyectos
    public function create()
    {
        return view('projects.create');
    }

    public function store(Request $request)
    {
        //dd($request->all());
        
        $request->validate([
            'name' => 'required|unique:nuevo_proyecto,name',
            'fecha_inicio' => 'required|date', // Validación para fecha de inicio
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio', // Validación para fecha de fin
            'estado' => 'required|in:activo,inactivo,completado', // Validación para estado
            'users' => 'required|string',
        ]);
    
        // Crear el proyecto con los nuevos campos
        $project = Project::create([
            'name' => $request->name,
            'fecha_inicio' => $request->fecha_inicio, // Guardar fecha de inicio
            'fecha_fin' => $request->fecha_fin, // Guardar fecha de fin
            'estado' => $request->estado, // Guardar estado
        ]);
    
        $userIds = explode(',', $request->users);
        $project->users()->attach($userIds);

        return redirect()->route('projects.my')->with('success', 'Proyecto creado exitosamente.');
    }

    public function index()
    {
        $nuevo_proyecto = Project::with('users')->get();
        return view('projects.create', compact('nuevo_proyecto')); // Esta es la vista que has compartido
    }

    public function myProjects()
    {
        $user = auth()->user();
        $projects = $user->projects;

        return view('projects.my_projects', compact('projects'));
    }

}