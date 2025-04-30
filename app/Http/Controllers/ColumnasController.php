<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Columna;
use App\Models\Tablero;

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

        $columnasExistentes = Columna::where('tablero_id', $request->tablero_id)->count();
        if ($columnasExistentes >= 9) {
            return response()->json(['mensaje' => 'No se pueden agregar más de 9 columnas.'], 400);
        }

        // Validar que exista el id del tablero y que se provea un nombre
        $validated = $request->validate([
            'tablero_id' => 'required|exists:tablero,id',
            'nombre'     => 'required|string|max:255',
            'position'   => 'nullable|integer'
        ]);

        // Crear la columna y asignar una posición (podrías calcular la posición sumando 1 a la última posición)
        $columna = Columna::create([
            'tablero_id' => $validated['tablero_id'],
            'nombre'     => $validated['nombre'],
            'position'   => $validated['position'] ?? 0
        ]);

        // Retornar una respuesta JSON para que el frontend sepa que fue exitoso
        return response()->json([
            'success' => true,
            'columna' => $columna
        ]);
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
