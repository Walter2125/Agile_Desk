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
        $request->validate([
            'name' => 'required|unique:nuevo_proyecto,name',
            'users' => 'required|string',
        ]);

        $project = Project::create([
            'name' => $request->name,
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