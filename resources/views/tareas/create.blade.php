@extends('adminlte::page')
@section('title', 'Agile Desk')
@section("adminlte_css")

@section('content')
<div class="container">
    <h2 class="mb-4">Crear Nueva Tarea</h2>

    <form action="{{ route('tareas.store') }}" method="POST">
        @csrf

    
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required>
        </div>


        <div class="mb-3">
            <label for="actividad" class="form-label">Actividad</label>
            <select class="form-select" id="actividad" name="actividad" required>
                <option value="Configuracion">Configuración</option>
                <option value="Desarrollo">Desarrollo</option>
                <option value="Prueba">Prueba</option>
                <option value="Diseño">Diseño</option>
            </select> <br>
                <label for="historia_id" class="form-label">Historia Asociada</label>
                <input type="hidden" name="historia_id" value="{{ $historia->id ?? ' ' }}">
                <input type="text" class="form-control" id="historia_nombre" value="{{ $historia->nombre ?? ' ' }}" readonly>
        </div>


        <div class="mb-3">
            <label for="asignado" class="form-label">Asignado a</label>
            <input type="text" class="form-control" id="asignado" name="asignado">
        </div>


         <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea class="form-control" id="descripcion" name="descripcion" rows="3"></textarea>
        </div>


        <div class="mb-3">
            <label for="historial" class="form-label">Historial</label>
            <textarea class="form-control" id="historial" name="historial" rows="3"></textarea>
        </div>


        <button type="submit" class="btn btn-primary">Guardar</button>
        <br>
    </form>
</div>

@endsection
@stop