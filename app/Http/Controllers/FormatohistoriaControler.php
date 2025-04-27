<?php

namespace App\Http\Controllers;

use App\Models\Formatohistoria;
use App\Models\HistoriaModel;
use App\Models\Notificaciones;
use App\Models\HistorialCambios;
use App\Models\ReasinarHistorias;
use App\Models\ListaHistoria;
use App\Models\Tablero;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Para obtener el usuario autenticado

class FormatohistoriaControler extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $historias = Formatohistoria::all(['id', 'nombre', 'responsable']);
        return view('formato.index', compact('historias'));
    }

    public function misHistorias()
    {
        $historias = Formatohistoria::where('user_id', auth()->id())
            ->select(['id', 'nombre', 'sprint', 'responsable', 'estado', 'created_at'])
            ->get();

        return view('ListaHistorias', compact('historias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Tablero $tablero)
    {
        return view('formato.create', compact('tablero'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Tablero $tablero)
    {
        $request->validate([
            'nombre' => [
                'required',
                'max:255',
                \Illuminate\Validation\Rule::unique('formatohistorias')->where(function ($query) use ($tablero) {
                    return $query->where('tablero_id', $tablero->id);
                }),
            ],
            'sprint' => 'nullable|integer|min:1',
            'trabajo_estimado' => 'nullable|integer|min:1',
            'responsable' => 'nullable|string|max:255',
            'prioridad' => 'required|in:Alta,Media,Baja',
            'descripcion' => 'nullable|string',
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.unique' => 'El nombre ya existe en este tablero, intente con otro.',
            'trabajo_estimado.min' => 'El Trabajo Estimado debe ser mayor a cero.',
            'prioridad.required' => 'La prioridad es requerida.',
        ]);

        $historia = new Formatohistoria();
        $historia->nombre = $request->nombre;
        $historia->sprint = $request->sprint;
        $historia->trabajo_estimado = $request->trabajo_estimado;
        $historia->responsable = $request->responsable;
        $historia->prioridad = $request->prioridad;
        $historia->descripcion = $request->descripcion;
        $historia->user_id = auth()->id();
        $historia->tablero_id = $tablero->id;
        $historia->save();

        // Enviar notificación
        Notificaciones::create([
            'title' => 'Nueva Historia',
            'message' => 'Has creado una nueva historia: ' . $historia->nombre,
            'user_id' => auth()->id(),
            'read' => false,
        ]);

        // Registrar en el historial de cambios
        HistorialCambios::create([
            'fecha' => now(),
            'usuario' => Auth::user()->name ?? 'Desconocido',
            'accion' => 'Creación',
            'detalles' => 'Se creó una nueva historia: ' . $historia->nombre,
            'sprint' => $historia->sprint,
        ]);

        return redirect()
            ->route('tableros.show', $tablero->id)
            ->with([
                'success' => 'Historia Creada correctamente',
                'fromCreate' => true,
            ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Formatohistoria $historia)
    {
        return view('formato.show', compact('historia'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $historia = Formatohistoria::findOrFail($id);

        if (session('fromEdit')) {
            return redirect()->route('tableros.show', $historia->tablero_id)->with('warning', 'No puedes volver al formulario de edición.');
        }

        return response()
            ->view('formato.edit', compact('historia'))
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $historia = Formatohistoria::findOrFail($id);

        $request->validate([
            'nombre' => [
                'required',
                'max:255',
                \Illuminate\Validation\Rule::unique('formatohistorias')->where(function ($query) use ($historia) {
                    return $query->where('tablero_id', $historia->tablero_id);
                })->ignore($historia->id),
            ],
            'sprint' => 'nullable|integer|min:1',
            'trabajo_estimado' => 'nullable|integer|min:1',
            'responsable' => 'nullable|string|max:255',
            'prioridad' => 'required|in:Alta,Media,Baja',
            'descripcion' => 'nullable|string',
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.unique' => 'El nombre ya existe en este tablero, intente con otro.',
            'trabajo_estimado.min' => 'El Trabajo Estimado debe ser mayor a cero.',
            'prioridad.required' => 'La prioridad es requerida.',
        ]);

        $datosAnteriores = $historia->getOriginal(); // Datos antes de actualizar

        $historia->update([
            'nombre' => $request->nombre,
            'sprint' => $request->sprint,
            'trabajo_estimado' => $request->trabajo_estimado,
            'responsable' => $request->responsable,
            'prioridad' => $request->prioridad,
            'descripcion' => $request->descripcion,
        ]);

        // Registrar los cambios
        $detalles = "Historia actualizada: " . $historia->nombre . ".\n";
        foreach ($historia->toArray() as $campo => $valorNuevo) {
            if ($datosAnteriores[$campo] != $valorNuevo) {
                $detalles .= ucfirst($campo) . " cambiado de '" . ($datosAnteriores[$campo] ?? 'N/A') . "' a '" . $valorNuevo . "'.\n";
            }
        }

        HistorialCambios::create([
            'fecha' => now(),
            'usuario' => Auth::user()->name ?? 'Desconocido',
            'accion' => 'Edición',
            'detalles' => $detalles,
            'sprint' => $historia->sprint,
        ]);

        return redirect()->route('tableros.show', $historia->tablero_id)->with([
            'success' => 'Historia Actualizada correctamente',
            'fromEdit' => true,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $historia = Formatohistoria::findOrFail($id);
        $nombreHistoria = $historia->nombre;

        // Notificar eliminación
        Notificaciones::create([
            'title' => 'Historia Eliminada',
            'message' => 'Se ha eliminado la historia: ' . $nombreHistoria,
            'user_id' => auth()->id(),
            'read' => false,
        ]);

        $historia->delete();

        // Registrar en historial
        HistorialCambios::create([
            'fecha' => now(),
            'usuario' => Auth::user()->name ?? 'Desconocido',
            'accion' => 'Eliminación',
            'detalles' => "Se eliminó la historia: " . $nombreHistoria,
            'sprint' => $historia->sprint,
        ]);

        return redirect()->route('tableros.show', $historia->tablero_id)
            ->with('success', 'Historia eliminada correctamente');
    }
}