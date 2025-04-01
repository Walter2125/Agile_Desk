<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Formatohistoria;

class TableroController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtener las historias y ordenarlas según prioridad
        $historias = Formatohistoria::all()->sortBy(function ($historia) {
            switch ($historia->prioridad) {
                case 'Alta':
                    return 1;
                case 'Media':
                    return 2;
                case 'Baja':
                    return 3;
                default:
                    return 4;
            }
        });

        return view('tablero',compact('historias'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $tablero = Tablero::findOrFail($id);
        return view('tableros.show', compact('tablero'));
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
            'nombre' => 'required|string|max:255',
        ]);

        $tablero = Tablero::findOrFail($id);
        $tablero->update($validated);

        return redirect()->route('tableros.show', $tablero->id)
            ->with('success', 'Tablero actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Tablero::destroy($id);
        return redirect()->route('tableros.index')
            ->with('success', 'Tablero eliminado correctamente.');
    }
}
