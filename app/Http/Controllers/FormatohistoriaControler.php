<?php

namespace App\Http\Controllers;

use App\Models\Formatohistoria;
use Illuminate\Http\Request;

class FormatohistoriaControler extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        return view('formato.index');
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
            'trabajo_estimado' => 'nullable|integer|min:1',
            'responsable' => 'nullable|string|max:255',
            'prioridad' => 'required|in:Alta,Media,Baja',
            'descripcion' => 'nullable|string',
        ]);
       
        $historia = new Formatohistoria();
        $historia->nombre = $request->nombre;//aqui aun falta mas revisar
        $historia->sprint = $request->sprint;
        $historia->trabajo_estimado = $request->trabajo_estimado;
        $historia->responsable = $request->responsable;
        $historia->prioridad = $request->prioridad;
        $historia->descripcion = $request->descripcion;
        $historia->save();



        return redirect('formato.index')->back()->with('success', 'Historia creada con éxito');
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
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
