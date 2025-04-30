<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Formatohistoria;
use App\Models\User;
use App\Models\HistorialCambios;
use App\Models\Project;


use App\Models\ReasinarHistorias;


class ReasignarHistoriaController extends Controller
{
    public function index(Project $project)
{
    // Historias solo del proyecto actual
    $historias = Formatohistoria::whereHas('tablero.project', function ($query) use ($project) {
        $query->where('id', $project->id);
    })->select('id', 'nombre', 'responsable')->get();

    $usuarios = User::all();

    return view('ReasignacionHistoria', compact('historias', 'usuarios', 'project'));
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
        'detalles' => "Historia '{$historia->nombre}' reasignada de '{$responsableAnterior}' a '{$nuevoResponsable}'.",
        'sprint' => $historia->sprint,
        'project_id' => $historia->tablero->project_id, // <<--- Esto es lo nuevo
    ]);

    return redirect()->route('tableros.show', $historia->tablero_id)->with('success', 'Responsable reasignado correctamente');}
}