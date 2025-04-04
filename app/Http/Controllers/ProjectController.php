<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use App\Models\Notificaciones;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    // Mostrar formulario de creación de proyectos
    public function create()
    {
        // Buscar todos los usuarios para mostrar en la búsqueda
        $users = User::all();

        // Obtener los usuarios seleccionados si se ha editado un proyecto
        $selectedUsers = [];

        return view('projects.create', compact('users', 'selectedUsers'));

    }

    public function store(Request $request)
    {
        // Validación
        $request->validate([
            'name' => 'required|unique:nuevo_proyecto,name', // Cambiado 'projects' por 'nuevo_proyecto'
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'users' => 'required|array|min:1',  // Aseguramos que al menos un usuario se seleccione
            'users.*' => 'exists:users,id', // Aseguramos que todos los usuarios seleccionados existen
        ]);

        // Crear el proyecto
        $project = Project::create([
            'name' => $request->name,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
            'user_id' => auth()->id(), // El usuario que crea el proyecto
        ]);
        
        $project->users()->attach(auth()->id());
        
        $usuarios = User::all();
        
        foreach ($usuarios as $usuario) {
            Notificaciones::create([
                'title' => 'Nuevo Proyecto',
                'message' => 'Se ha creado un nuevo proyecto: ' . $project->name,
                'user_id' => $usuario->id,
                'read' => false,
            ]);
        }

        if ($request->has('users')) {
            $project->users()->attach($request->users);
        }

        logger()->info('Proyecto creado:', [
            'project' => $project->toArray(),
            'users' => $project->users->pluck('id')
        ]);
        return redirect()->route('projects.my')->with('success', 'Proyecto creado exitosamente.');
    }


    public function index()
    {
        $nuevo_proyecto = Project::with('users')->get();

        //$nuevo_proyecto = Project::with('users')->orderBy('created_at', 'desc')->get();

        return view('projects.create', compact('nuevo_proyecto'));
    }

    public function myProjects()
    {
        $user = auth()->user();
        $projects = $user->projects;

        return view('projects.my_projects', compact('projects')); 
        
    }

    public function edit($id)
    {
        // Obtener el proyecto por su ID, con los usuarios asignados
        $project = Project::with('users')->findOrFail($id);

        // Verificar si el usuario logueado es el propietario del proyecto
        if (auth()->id() !== $project->user_id) {
            return redirect()->route('projects.my')->with('error', 'No tienes permiso para editar este proyecto.');
        }

        // Obtener todos los usuarios
        $users = User::all();

        return view('projects.edit', compact('project', 'users'));
    }

    public function update(Request $request, $id)
    {
        // Validación de datos
        $request->validate([
            'name' => 'required|unique:nuevo_proyecto,name,' . $id,
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'users' => 'required|array|min:1', // Aseguramos que al menos un usuario se seleccione
            'users.*' => 'exists:users,id', // Aseguramos que todos los usuarios seleccionados existen
        ]);

        // Buscar el proyecto a actualizar
        $project = Project::findOrFail($id);

        // Verificar si el usuario logueado es el propietario del proyecto
        if (auth()->id() !== $project->user_id) {
            return redirect()->route('projects.my')->with('error', 'No tienes permiso para editar este proyecto.');
        }

        // Actualizar el proyecto
        $project->update([
            'name' => $request->name,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
        ]);

        // Agregar el creador del proyecto a la lista de usuarios, si no está ya en la lista
        $users = $request->users;
        if (!in_array($project->user_id, $users)) {
            $users[] = $project->user_id; // Aseguramos que el creador siempre esté incluido
        }

        // Sincronizar los usuarios asignados al proyecto, asegurando que el creador siempre esté incluido
        $project->users()->sync($users);

        return redirect()->route('projects.my')->with('success', 'Proyecto actualizado exitosamente.');
    }



    public function removeUser($projectId, $userId)
    {
        $project = Project::findOrFail($projectId);
        $user = User::findOrFail($userId);

        if ($project->users->contains($user)) {
            $project->users()->detach($user);
            return response()->json(['success' => 'Usuario eliminado exitosamente'], 200);
        }

        return response()->json(['error' => 'El usuario no está asociado a este proyecto'], 404);
    }

    public function destroy($id)
    {
        $project = Project::findOrFail($id);

        if (auth()->id() !== $project->user_id) {
            return redirect()->route('projects.my')->with('error', 'No tienes permiso para eliminar este proyecto.');
        }

        $project->delete();

        return redirect()->route('projects.my')->with('success', 'Proyecto eliminado exitosamente.');
    }

    public function searchUsers(Request $request)
    {
        $query = $request->input('query');

        // Filtrar usuarios según el nombre, excluyendo al usuario autenticado
        $users = User::where('name', 'like', "%{$query}%")
            ->where('id', '!=', auth()->id()) // Excluir al usuario autenticado
            ->get();

        // Retornar los usuarios como JSON
        return response()->json($users);
    }


}