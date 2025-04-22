<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ListaHistoria;
use App\Models\Formatohistoria;


class ListaHistoriaController extends Controller
{
    public function index()
    {
        // Solo mostrar las historias del usuario autenticado
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'responsable' => 'nullable|string|max:255',
            'sprint' => 'nullable|integer|min:1',
        ]);

        ListaHistoria::create([
            'nombre' => $request->nombre,
            'responsable' => $request->responsable,
            'sprint' => $request->sprint,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('lista_historias.index')->with('success', 'Historia creada correctamente.');
    }
}