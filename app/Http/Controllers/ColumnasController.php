<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ColumnasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tablero_id' => 'required|exists:tableros,id',
            'nombre'     => 'required|string|max:255',
            'position'   => 'nullable|integer'
        ]);

        Columna::create($validated);

        return redirect()->back()->with('success', 'Columna creada correctamente.');
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
        $validated = $request->validate([
            'nombre'   => 'required|string|max:255',
            'position' => 'nullable|integer'
        ]);

        $columna = Columna::findOrFail($id);
        $columna->update($validated);

        return redirect()->back()->with('success', 'Columna actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Columna::destroy($id);
        return redirect()->back()->with('success', 'Columna eliminada correctamente.');

    }
}
