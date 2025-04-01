<?php

namespace App\Http\Controllers;

use App\Models\Formatohistoria;
use App\Models\Tareas;
use App\Models\HistoriaModel;
use Illuminate\Http\Request;

class TareasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $tareas = Tareas::with('historia')->get();
        $historias = Formatohistoria::all();
        return view('tareas.index', compact('tareas','historias'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        //
        $historia = Formatohistoria::find($request->historia_id);
        return view('tareas.create',compact('historia',));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'historial' => 'nullable|string',
            'actividad' => 'required|in:Configuracion,Desarrollo,Prueba,Diseño',
            'asignado' => 'nullable|string|max:255',
            'historia_id' => 'required|exists:formatohistorias,id',
        ]);
    
        Tareas::create($request->all());
    
        return redirect()->route('tareas.index')->with('success', 'Tarea creada correctamente.');
    

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $tarea = Tareas::findOrFail($id);
        $historias = FormatoHistoria::all(); 
    
        return view('tareas.edit', compact('tarea', 'historias'));
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'historial' => 'nullable|string',
            'actividad' => 'required|in:Configuracion,Desarrollo,Prueba,Diseño',
            'asignado' => 'nullable|string|max:255',
            'historia_id' => 'required|exists:formatohistorias,id',
        ]);
    
        $tarea = Tareas::findOrFail($id);
        $tarea->update([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'historial' => $request->historial,
            'actividad' => $request->actividad,
            'asignado' => $request->asignado,
            'historia_id' => $request->historia_id,
        ]);
    
        return redirect()->route('tareas.index')->with('success', 'Tarea actualizada correctamente.');
    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
