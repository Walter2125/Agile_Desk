@extends('adminlte::page')

@section('title', 'Agile Desk')

@section('adminlte_css')
    <link rel="stylesheet" href="{{ asset('css/tareas.css') }}">
@endsection

@section('Mensaje')
    <li class="nav-item d-flex align-items-center ps-3 mensaje-titulo">
        <span class="titulo-formulario">
            Crear nueva tarea
        </span>
    </li>
@endsection

@section('content')

<div class="container-fluid contenedor-formulario ">
   
        <form action="{{ route('tareas.store') }}" method="POST">
            @csrf
            <div class="col md">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>

            <div class="row g-2">
                    <div class="col-md-3">
                    <label for="historia_id" class="form-label">Historia Asociada</label>
                    <input type="hidden" name="historia_id" value="{{ $historia->id ?? '' }}">
                    <input type="text" class="form-control" id="historia_nombre" value="{{ $historia->nombre ?? '' }}" readonly>
                    </div>
                    <div class="col md">
                        <label for="asignado" class="form-label">Asignado a</label>
                        <input type="text" class="form-control" id="asignado" name="asignado">
                    </div>
                    <div class="col-md-4">
                        <div class="container mt-4">
                        <label for="actividad" class="form-label"> Actividad</label>
                            <select class="form-select" aria-label="Default select example" id="actividad" name="actividad" required >
                                <option value="Configuracion">Configuración</option>
                                <option value="Desarrollo">Desarrollo</option>
                                <option value="Prueba">Prueba</option>
                                <option value="Diseño">Diseño</option>
                            </select>
                            </div>
                    </div >
            </div>
            <div class="row g-2">
            <div class="col mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea class="form-control" id="descripcion" name="descripcion" rows="3"></textarea>
            </div>

            <div class="col md">
                <label for="historial" class="form-label">Historial</label>
                <textarea class="form-control" id="historial" name="historial" rows="3"></textarea>
            </div>

            </div>

            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <div class="row mb-3">
                <div class="col-md">
                <a href="{{ route('formulario.show', $historia->id) }}" class="btn btn-secondary me-2">Volver</a>
                <button class="btn btn-primary boton-guardar" type="submit">Guardar</button>
                
                </div>
                </div>
            </div>
        </form>
</div>
@endsection