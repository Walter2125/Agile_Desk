<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Formatohistoria;
use App\Models\User;
use App\Models\HistorialCambios;


use App\Models\ReasinarHistorias;


class ReasignarHistoriaController extends Controller
{
    public function index()
    {
        $historias = Formatohistoria::select('id', 'nombre', 'responsable')->get();  // Asegurarte de incluir 'responsable'
        $usuarios = User::all();  // O el modelo adecuado para obtener los usuarios
    
        return view('ReasignacionHistoria', compact('historias', 'usuarios'));
    }

    public function reasignar(Request $request)
{
    $request->validate([
        'historiaId' => 'required|exists:formatohistorias,id',
        'nuevoResponsableId' => 'required|exists:users,id',
    ]);

    $historia = Formatohistoria::findOrFail($request->historiaId);
    $responsableAnterior = $historia->responsable;
    $nuevoResponsable = User::findOrFail($request->nuevoResponsableId)->name;
    $historia->responsable = $nuevoResponsable;
    $historia->save();

    // Registrar el cambio en el historial
    HistorialCambios::create([
        'fecha' => now(),
        'usuario' => auth()->user()->name ?? 'Sistema',
        'accion' => 'Reasignación',
        'detalles' => "Historia '{$historia->nombre}' reasignada de '{$responsableAnterior}' a '{$nuevoResponsable}'."
    ]);

    return redirect()->route('historialcambios.index')->with('success', 'Responsable reasignado correctamente');
}
}