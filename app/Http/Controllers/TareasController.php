<?php

namespace App\Http\Controllers;

use App\Models\Formatohistoria;
use App\Models\Tareas;
use Illuminate\Http\Request;

class TareasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtener todas las tareas junto con la historia asociada
        $tareas = Tareas::with('historia')->get();
        $historias = Formatohistoria::all();
    
        $tablero = null;
        if ($tareas->count() > 0 && $tareas->first()->historia) {
            $tablero = $tareas->first()->historia->tablero;
        }
    
        return view('tareas.index', compact('tareas', 'historias', 'tablero'));
    }

    public function indexPorHistoria($id)
    {
        // Obtener la historia
        $historia = FormatoHistoria::findOrFail($id);
    
        // Obtener las tareas asociadas a esa historia
        $tareas = Tareas::where('historia_id', $id)->get();
    
        // Pasar los datos a la vista
        return view('tareas.index', compact('tareas', 'historia'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        // Recuperar la historia correspondiente al `historia_id` enviado en el request
       

        if (session('fromCreateTarea')) {
            return redirect()->route('tablero')->with('warning', 'No puedes volver al formulario de creación de tareas.');
        }
    
        $historia = Formatohistoria::find($request->historia_id);
        $tablero = $historia?->tablero; 
    
        return response()
            ->view('tareas.create', compact('historia', 'tablero'))
            ->header('Cache-Control','no-cache, no-store, must-revalidate')
            ->header('Pragma','no-cache')
            ->header('Expires','0');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validación de los datos recibidos
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'historial' => 'nullable|string',
            'actividad' => 'required|in:Configuracion,Desarrollo,Prueba,Diseño',
            'asignado' => 'nullable|string|max:255',
            'historia_id' => 'required|exists:formatohistorias,id', // Aseguramos que el `historia_id` existe
        ],[
            'nombre.required' => 'El nombre es obligatorio.',
            'actividad.required' => 'La Activiad es requerida',
        ]);

        // Crear la tarea con los datos validados
        Tareas::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'historial' => $request->historial,
            'actividad' => $request->actividad,
            'asignado' => $request->asignado,
            'historia_id' => $request->historia_id, // El id de la historia
        ]);

        // Redirigir con un mensaje de éxitoreturn redirect()->route('tareas.index')->with([
            return redirect()->route('tareas.porHistoria', $request->historia_id)->with([
                'success' => 'Tarea creada correctamente.',
                'fromCreate' => true,
            ]);
    }
            

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Este método no está siendo utilizado actualmen
        $tarea = Tareas::with('historia')->findOrFail($id);
        return view('tareas.show', compact('tarea'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        
    if (session('fromEditTarea')) {
        return redirect()->route('tablero')->with('warning', 'No puedes volver al formulario de edición de tareas.');
    }

    $tarea = Tareas::findOrFail($id);
    $historias = Formatohistoria::all();
    $tablero = $tarea->historia->tablero; 

    return response()
        ->view('tareas.edit', compact('tarea', 'historias', 'tablero'))
        ->header('Cache-Control','no-cache, no-store, must-revalidate')
        ->header('Pragma','no-cache')
        ->header('Expires','0');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validación de los datos recibidos
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'historial' => 'nullable|string',
            'actividad' => 'required|in:Configuracion,Desarrollo,Prueba,Diseño',
            'asignado' => 'nullable|string|max:255'
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'actividad.required' => 'La Activiad es requerida',

        ]);
    
        // Obtener la tarea a actualizar
        $tarea = Tareas::findOrFail($id);
        // Actualizar los datos de la tarea
        $tarea->update([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'historial' => $request->historial,
            'actividad' => $request->actividad,
            'asignado' => $request->asignado,
            'historia_id' =>$tarea->historia_id// Aseguramos que se esté pasando el `historia_id`
        ]);
    
        // Redirigir con un mensaje de éxito a la ruta del tablero
        return redirect()->route('tareas.index')->with([
            'success' => 'Tarea actualizada correctamente',
            'fromEditTarea' => true, // <- Esto activa el bloqueo
        ]);
    
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Eliminar la tarea
        $tarea = Tareas::findOrFail($id);
        $tarea->delete();

        // Redirigir con mensaje de éxito
        return redirect()->route('tareas.index')->with('success', 'Tarea eliminada correctamente.');
    }
}

