<?php

namespace App\Http\Controllers;

use App\Models\Formatohistoria;
use App\Models\HistoriaModel;
use App\Models\Notificaciones;
use App\Models\HistorialCambios;
use App\Models\ReasinarHistorias;
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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('formato.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|unique:formatohistorias,nombre|max:255', 
            //'sprint' => 'required|integer|min:1',
            'trabajo_estimado' => 'integer|min:1',
            'responsable' => 'nullable|string|max:255',
            'prioridad' => 'required|in:Alta,Media,Baja',
            'descripcion' => 'nullable|string',],
            [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.unique' =>'El nombre ya existe, intente con otro.',//personalizacion de alertas.
            'trabajo_estimado.min' =>'El Trabajo Estimado debe ser mayor a cero.',
            'prioridad.required'=> 'La prioridad es requerida.'
        ]);
       
        $historia = new Formatohistoria();
        $historia->nombre = $request->nombre;//aqui aun falta mas revisar
        //$historia->sprint = $request->sprint;
        $historia->trabajo_estimado = $request->trabajo_estimado;
        $historia->responsable = $request->responsable;
        $historia->prioridad = $request->prioridad;
        $historia->descripcion = $request->descripcion;
        $historia->save();

        // Enviar notificación al usuario autenticado
        Notificaciones::create([
            'title' => 'Nueva Historia',
            'message' => 'Has creado una nueva historia: ' . $historia->nombre,
            'user_id' => auth()->id(),
            'read' => false,
        ]);

        // Registrar en el historial de cambios
        HistorialCambios::create([
            'fecha' => now(),
            'usuario' => Auth::user()->name ?? 'Desconocido', // Usuario autenticado o "Desconocido"
            'accion' => 'Creación',
            'detalles' => 'Se creó una nueva historia: ' . $historia->nombre,
        ]);

        session()->flash('success','Historia Creada correctamente');
        return redirect()->route('tablero');//aqui devera devolver al tablero donde se haga la conexion 
        

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
    public function edit($id)
    {
        //
        $historia = Formatohistoria::findOrFail($id);
        return view('formato.edit',compact('historia'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $request->validate([
            'nombre' => 'required|max:255|unique:formatohistorias,nombre,' . $id, 
            'sprint' => 'required|integer|min:1',
            'trabajo_estimado' => 'nullable|integer|min:1',
            'responsable' => 'nullable|string|max:255',
            'prioridad' => 'required|in:Alta,Media,Baja',
            'descripcion' => 'nullable|string',
        ], [
            'nombre.unique' => 'El nombre ya existe, intente con otro.',
            'prioridad.required' => 'La prioridad es requerida.'
        ]);
        $historia = Formatohistoria::findOrFail($id);
    $historia->update([
        'nombre' => $request->nombre,
        'sprint' => $request->sprint,
        'trabajo_estimado' => $request->trabajo_estimado,
        'responsable' => $request->responsable,
        'prioridad' => $request->prioridad,
        'descripcion' => $request->descripcion,
    ]);

    // Determinar cambios
    $detalles = "Historia actualizada: " . $historia->nombre . ".\n";
    foreach ($historia->toArray() as $campo => $valorNuevo) {
        if ($datosAnteriores[$campo] != $valorNuevo) {
            $detalles .= ucfirst($campo) . " cambiado de '" . ($datosAnteriores[$campo] ?? 'N/A') . "' a '" . $valorNuevo . "'.\n";
        }
    }

    // Registrar en el historial de cambios
    HistorialCambios::create([
        'fecha' => now(),
        'usuario' => Auth::user()->name ?? 'Desconocido',
        'accion' => 'Edición',
        'detalles' => $detalles,
    ]);

    session()->flash('success','Historia Actualizada correctamente');
    return redirect()->route('tablero');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
    $historia = Formatohistoria::findOrFail($id);
    $nombreHistoria = $historia->nombre;

    // Notificar al usuario autenticado sobre la eliminación
    Notificaciones::create([
        'title' => 'Historia Eliminada',
        'message' => 'Se ha eliminado la historia: ' . $nombreHistoria,
        'user_id' => auth()->id(),
        'read' => false,
    ]);

    // Eliminar la historia
    $historia->delete();

    // Registrar en el historial de cambios
    HistorialCambios::create([
        'fecha' => now(),
        'usuario' => Auth::user()->name ?? 'Desconocido',
        'accion' => 'Eliminación',
        'detalles' => "Se eliminó la historia: " . $nombreHistoria,
    ]);

    session()->flash('success', 'Historia eliminada correctamente');
    return redirect()->route('tablero');
    }
