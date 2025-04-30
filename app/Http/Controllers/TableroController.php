<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Tablero;
use App\Models\Columna;
use App\Models\Formatohistoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TableroController extends Controller
{
    /**
     * Mostrar todos los tableros del usuario actual
     */
    public function index()
{
    // 1. IDs de historias ya archivadas
    $historiasArchivadasIds = \App\Models\ArchivoHistoria::pluck('historia_id');

    // 2. Historias NO archivadas, ordenadas por prioridad
    $historias = Formatohistoria::whereNotIn('id', $historiasArchivadasIds)
        ->get()
        ->sortBy(function ($historia) {
            switch ($historia->prioridad) {
                case 'Alta':  return 1;
                case 'Media': return 2;
                case 'Baja':  return 3;
                default:      return 4;
            }
        });

    // 3. Aquí **sí** pasamos $historias a la vista
    return view('tablero', compact('historias'));
}


    /**
     * Formulario para crear un tablero (solo si el proyecto no tiene uno)
     */
    public function create(Project $proyecto)
    {
       //
    }

    /**
     * Almacenar un nuevo tablero
     */
    public function store(Request $request, Project $proyecto)
    {
        // Verificar que el usuario tiene acceso al proyecto
        if (!Auth::user()->projects->contains($proyecto->id)) {
            return redirect()->route('projects.my')
                ->with('error', 'No tienes acceso a este proyecto.');
        }

        // Verificar si el proyecto ya tiene un tablero
        if ($proyecto->tablero) {
            return redirect()->route('tableros.show', $proyecto->tablero->id)
                ->with('info', 'Este proyecto ya tiene un tablero.');
        }

        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        // Crear el tablero
        $tablero = new Tablero();
        $tablero->nombre = $request->nombre;
        $proyecto->tablero()->save($tablero);

        // Crear columnas predeterminadas
        $columnasDefault = ['Por hacer', 'En progreso', 'Terminado'];
        $orden = 1;

        foreach ($columnasDefault as $nombreColumna) {
            $columna = new Columna();
            $columna->nombre = $nombreColumna;
            $columna->orden = $orden++;
            $tablero->columnas()->save($columna);
        }

        return redirect()->route('tableros.show', $tablero->id)
            ->with('success', 'Tablero creado exitosamente.');
    }

    /**
     * Mostrar un tablero específico
     */

     public function show($id)
     {
        $tablero = Tablero::with([
            'project.sprints' => function($query) {
                $query->orderBy('fecha_inicio');
            },
            'historias'
        ])->findOrFail($id);
        
        // Obtener los sprints únicos del proyecto
        $sprints = $tablero->project->sprints->unique('id');
    
        // Verificar que el usuario tiene acceso al proyecto asociado
        if (!$tablero->project || !Auth::user()->projects->contains($tablero->project->id)) {
            return redirect()->route('projects.my')
                ->with('error', 'No tienes acceso a este tablero.');
        }
        
        return view('tablero', compact('tablero', 'sprints'));
  /*
         $tablero = Tablero::with(['columnas.historias', 'project'])->findOrFail($id);

         // Verificar que el usuario tiene acceso al proyecto asociado
         if (!$tablero->project || !Auth::user()->projects->contains($tablero->project->id)) {
             return redirect()->route('projects.my')
                 ->with('error', 'No tienes acceso a este tablero.');
         }

         // Pasar el tablero a la vista
         return view('tablero', compact('tablero'));
*/

     }

    /**
     * Formulario para borrar un tablero
     */
    public function destroy(Tablero $tablero)
    {
        // Verificar que el usuario tiene acceso al proyecto asociado
        if (!$tablero->project || !Auth::user()->projects->contains($tablero->project->id)) {
            return redirect()->route('projects.my')
                ->with('error', 'No tienes acceso a este tablero.');
        }

        // Opcional: Verificar si el usuario es administrador o dueño del proyecto
        if (Auth::user()->usertype != 'admin' && Auth::user()->id != $tablero->proyecto->user_id) {
            return redirect()->route('projects.my')
                ->with('error', 'No tienes permiso para eliminar este tablero.');
        }

        // Antes de eliminar el tablero, guarda una referencia al proyecto
        $proyecto = $tablero->proyecto;

        // Eliminar el tablero y sus relaciones (asegúrate de tener configurado el onDelete cascade en tus migraciones)
        $tablero->delete();

        return redirect()->route('projects.my')
            ->with('success', 'Tablero eliminado exitosamente.');
    }
}
