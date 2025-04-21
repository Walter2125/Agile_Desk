<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ArchivoHistoria;
use App\Models\Formatohistoria;

class ArchivoHistoriaController extends Controller {
    public function mostrarHistoriasDisponibles() {
        $historias = FormatoHistoria::whereNotIn('id', ArchivoHistoria::pluck('historia_id'))->get();
        return view('seleccionar', compact('historias'));
    }

    public function archivar($id) {
        ArchivoHistoria::create([
            'historia_id' => $id,
            'archivado_en' => now(),
        ]);

        return redirect()->route('archivo.index')->with('success', 'Historia archivada correctamente.');
    }

    public function index() {
        $historiasArchivadas = ArchivoHistoria::with('historia')->get();
        return view('ArchivoHistoria', compact('historiasArchivadas'));
    }

    public function desarchivar($id) {
        ArchivoHistoria::where('historia_id', $id)->delete();
        return redirect()->route('tablero')->with('success', 'Historia desarchivada correctamente.');
    }
}
