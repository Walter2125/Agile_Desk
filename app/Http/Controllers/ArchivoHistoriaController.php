<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ArchivoHistoria;
use App\Models\Formatohistoria;
use App\Models\Project;

class ArchivoHistoriaController extends Controller
{
    public function mostrarHistoriasDisponibles(Project $project)
    {
        $historias = FormatoHistoria::where('project_id', $project->id)
            ->whereNotIn('id', ArchivoHistoria::pluck('historia_id'))
            ->get();

        return view('seleccionar', compact('historias', 'project'));
    }

    public function archivar(Project $project, $id)
    {
        ArchivoHistoria::create([
            'historia_id' => $id,
            'archivado_en' => now(),
        ]);

        return redirect()->route('archivo.seleccionar', $project->id)->with('success', 'Historia archivada correctamente.');
    }

    public function desarchivar(Project $project, $id)
    {
        ArchivoHistoria::where('historia_id', $id)->delete();

        return redirect()->route('archivo.index.proyecto', $project->id)->with('success', 'Historia desarchivada correctamente.');
    }

    public function indexPorProyecto(Project $project)
    {
        $historiasArchivadas = ArchivoHistoria::whereHas('historia', function ($query) use ($project) {
            $query->where('project_id', $project->id);
        })->with('historia')->get();

        return view('ArchivoHistoria', compact('historiasArchivadas', 'project'));
    }
}
