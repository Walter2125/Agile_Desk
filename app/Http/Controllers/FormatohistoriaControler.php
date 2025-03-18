<?php

namespace App\Http\Controllers;

use App\Models\Formatohistoria;
use App\Models\HistoriaModel;
use Illuminate\Http\Request;

class FormatohistoriaControler extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $historias = Formatohistoria::all();
        return view('formato.index', compact('historias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('formato.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|unique:formatohistorias,nombre|max:255', 
            'sprint' => 'required|integer|min:1',
            'trabajo_estimado' => 'nullable|integer|min:0',
            'responsable' => 'nullable|string|max:255',
            'prioridad' => 'required|in:Alta,Media,Baja',
            'descripcion' => 'nullable|string',],
            [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.unique' =>'El nombre ya existe, intente con otro.',//personalizacion de alertas.
            'trabajo_estimado.min' =>'El Trabajo Estimado debe ser mayor a cero.',
            'sprint.required'=>'El Sprint es requerido.',
            'prioridad.required'=> 'La prioridad es requerida.'
        ]);
       
        $historia = new Formatohistoria();
        $historia->nombre = $request->nombre;//aqui aun falta mas revisar
        $historia->sprint = $request->sprint;
        $historia->trabajo_estimado = $request->trabajo_estimado;
        $historia->responsable = $request->responsable;
        $historia->prioridad = $request->prioridad;
        $historia->descripcion = $request->descripcion;
        $historia->save();



        return redirect()->route('tablero')->with('success', ' ');//aqui devera devolver al tablero donde se haga la conexion 
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
    public function edit($id)
    {
        //
        $historia = Formatohistoria::findOrFail($id);
        return view('formato.edit',compact('historia'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $request->validate([
            'nombre' => 'required|max:255|unique:formatohistorias,nombre,' . $id, 
            'sprint' => 'required|integer|min:1',
            'trabajo_estimado' => 'nullable|integer|min:1',
            'responsable' => 'nullable|string|max:255',
            'prioridad' => 'required|in:Alta,Media,Baja',
            'descripcion' => 'nullable|string',
        ], [
            'nombre.unique' => 'El nombre ya existe, intente con otro.',
            'sprint.required' => 'El Sprint es requerido.',
            'prioridad.required' => 'La prioridad es requerida.'
        ]);
        $historia = Formatohistoria::findOrFail($id);
    $historia->update([
        'nombre' => $request->nombre,
        'sprint' => $request->sprint,
        'trabajo_estimado' => $request->trabajo_estimado,
        'responsable' => $request->responsable,
        'prioridad' => $request->prioridad,
        'descripcion' => $request->descripcion,
    ]);

    return redirect()->route('form.index')->with('success', 'Historia actualizada correctamente');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
         
    $historia = Formatohistoria::findOrFail($id);
    $historia->delete();
    return redirect()->route('form.index')->with('success', 'Historia eliminada correctamente');

    }
}
