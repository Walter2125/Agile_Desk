<?php

namespace App\Http\Controllers;

use App\Models\Columna;
use App\Models\Project;
use App\Models\User;
use App\Models\Notificaciones;
use App\Models\tablero;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
    // Mostrar formulario de creación de proyectos
    public function create()
    {
        // Buscar todos los usuarios para mostrar en la búsqueda
        $users = User::where('role', '!=', 'admin')->paginate(5); // 5 usuarios por página, excluyendo al admin

        // Obtener los usuarios seleccionados si se ha editado un proyecto
        $selectedUsers = [];

        return view('projects.create', compact('users', 'selectedUsers'));

    }



    public function store(Request $request)
{
    // Validación
    $request->validate([
        'name' => 'required|unique:nuevo_proyecto,name',
        'fecha_inicio' => 'required|date',
        'fecha_fin'    => 'required|date|after_or_equal:fecha_inicio',
        'users'        => 'required|string', // Recibes como STRING, no como array
    ]);

    // Convertir la cadena de usuarios separados por comas en un array
    $userIds = array_map('intval', explode(',', $request->users));

    if (empty($userIds)) {
        return back()->withErrors(['users' => 'Debe seleccionar al menos un usuario.']);
    }

    $tablero = DB::transaction(function () use ($request, $userIds) {
        // Crear proyecto
        $project = Project::create([
            'name'         => $request->name,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin'    => $request->fecha_fin,
            'user_id'      => auth()->id(),
        ]);

        // Asignar usuarios (incluye al creador)
        $project->users()->sync(array_unique(array_merge([$project->user_id], $userIds)));

        // Notificar usuarios asignados
        foreach ($project->users as $usuario) {
            Notificaciones::create([
                'title'   => 'Nuevo Proyecto',
                'message' => 'Se ha creado un nuevo proyecto: ' . $project->name,
                'user_id' => $usuario->id,
                'read'    => false,
            ]);
        }

        // Crear tablero
        $tablero = $project->tablero()->create([
            'nombre' => 'Tablero de ' . $project->name,
        ]);

        // Crear columnas predeterminadas
        $tablero->columna()->createMany([
            ['nombre' => 'Por hacer'],
            ['nombre' => 'En progreso'],
            ['nombre' => 'Terminado'],
        ]);

        return $tablero;
    });

    return response()->json([
        'redirect' => route('tableros.show', $tablero->id),
    ]);
}

   

    public function index()
    {
        $nuevo_proyecto = Project::with('users')->orderBy('created_at', 'desc')->get();
    
        return view('projects.create', compact('nuevo_proyecto'));
    }

    public function myProjects()
    {
        $user = auth()->user();
        $projects = $user->projects->sortByDesc('created_at');
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


    public function destroy(Request $request, $id)
{
    $project = Project::find($id);

    if (!$project) {
        return $request->expectsJson()
            ? response()->json(['error' => 'Proyecto no encontrado.'], 404)
            : redirect()->route('projects.my')->with('error', 'Proyecto no encontrado.');
    }

    if (Auth::user()->usertype != 'admin') {
        return $request->expectsJson()
            ? response()->json(['error' => 'No tienes permiso para eliminar este proyecto.'], 403)
            : redirect()->route('projects.my')->with('error', 'No tienes permiso.');
    }

    try {
        $project->delete();

        return $request->expectsJson()
            ? response()->json(['message' => 'Proyecto eliminado exitosamente.'])
            : redirect()->route('projects.my')->with('success', 'Proyecto eliminado exitosamente.');
    } catch (\Exception $e) {
        return $request->expectsJson()
            ? response()->json(['error' => 'Error al eliminar el proyecto: ' . $e->getMessage()], 500)
            : redirect()->route('projects.my')->with('error', 'Error al eliminar el proyecto.');
    }
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

    public function listUsers(Request $request)
{
    $search = $request->input('search', '');
    
    $users = User::where('role', '!=', 'admin')
                ->when($search, function($query) use ($search) {
                    return $query->where('name', 'like', '%'.$search.'%');
                })
                ->paginate(5);
    
    if($request->ajax()) {
        $html = view('projects.partials.users_table', compact('users'))->render();
        $pagination = $users->links()->toHtml();
        
        return response()->json([
            'html' => $html,
            'pagination' => $pagination
        ]);
    }
    
    return view('projects.create', compact('users'));
}
}