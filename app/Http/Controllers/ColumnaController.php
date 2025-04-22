<?php

namespace App\Http\Controllers;

use App\Models\Columna;
use Illuminate\Http\Request;

class ColumnaController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'tablero_id' => 'required|exists:tableros,id',
            'nombre'     => 'required|string|max:255',
            'orden'      => 'nullable|integer',
        ]);

        $columna = Columna::create($request->all());

        return response()->json(['mensaje' => 'Columna creada', 'columna' => $columna]);
    }

    public function update(Request $request, $id)
    {
        $columna = Columna::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        $columna->update($request->only('nombre'));

        return response()->json(['exito' => true, 'columna' => $columna]);
    }

    public function destroy($id)
    {
        $columna = Columna::findOrFail($id);
        $columna->delete();

        return response()->json(['mensaje' => 'Columna eliminada']);
    }
}

