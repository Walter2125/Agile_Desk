<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;    
use App\Models\Sprint;

class FullCalendarController extends Controller
{
    public function index()
    {
       // $sprint = Sprint::all();
        return view('fullcalendar');//, compact('sprint'));
    }

    public function ajax(Request $request)
    {
    $sprints = Sprint::all()->map(function ($sprint) {
        return [
            'id'      => $sprint->id,
            'title'   => $sprint->nombre, 
            'start'   => $sprint->fecha_inicio,
            'end'     => $sprint->fecha_fin,
            'allDay'  => true, 
        ];
    });

    return response()->json($sprints);
    }

    //
    public function store(Request $request)
    {
    try {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'start' => 'required|date',
            'end'   => 'required|date|after_or_equal:start',
        ]);

        $sprint = Sprint::create([
            'nombre'      => $validatedData['title'],
            'fecha_inicio'=> $validatedData['start'],
            'fecha_fin'   => $validatedData['end'],
            'estado'      => 'nuevo', // Aquí solo va un valor válido
        ]);

        return response()->json($sprint, 201);
    } catch (\Exception $e) {
        return response()->json([
            'error' => 'Error al crear el sprint',
            'message' => $e->getMessage()
        ], 500);
    }
}

}
