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

    // Guardar proyecto y asociar usuarios
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:nuevo_proyecto,name',
            'sprint_number' => 'required|integer',
            'users' => 'required|string',
        ]);

        // Crear el proyecto
        $project = Project::create([
            'name' => $request->name,
            'sprint_number' => $request->sprint_number,
        ]);

        // Convertir la cadena de IDs en un array y asociar usuarios al proyecto
        $userIds = explode(',', $request->users);
        $project->users()->attach($userIds);

        return redirect()->route('projects.create')->with('success', 'Proyecto creado exitosamente.');
    }

    public function index()
    {
        $nuevo_proyecto = Project::with('users')->get();
        return view('projects.create', compact('nuevo_proyecto')); // Esta es la vista que has compartido
    }
}
