@extends('adminlte::page')

@section('title', 'Agile Desk')

@section('adminlte_css')
    <link rel="stylesheet" href="{{ asset('css/tareas.css') }}">
@endsection

@section('Mensaje')
    <li class="nav-item d-flex align-items-center ps-3 mensaje-titulo">
        <span class="titulo-formulario">
            Detalles de la tarea
        </span>
    </li>

@endsection

@section('content')

<div class="container-fluid contenedor-formulario ">
    <div class="col md">
        <label for="nombre" class="form-label">Nombre</label>
        <input type="text" class="form-control" id="nombre" value="{{ $tarea->nombre }}" readonly>
    </div>

    <div class="row g-2">
        <div class="col-md-3">
            <label for="historia_id" class="form-label">Historia Asociada</label>
            <input type="text" class="form-control" id="historia_nombre" value="{{ $tarea->historia->nombre ?? 'Sin historia' }}" readonly>
        </div>
        <div class="col-md-3">
            <label for="asignado" class="form-label">Asignado a</label>
            <input type="text" class="form-control" id="asignado" value="{{ $tarea->asignado }}" readonly>
        </div>
        <div class="col md">
                <label for="actividad" class="form-label">Actividad</label>
                <input type="text" class="form-control" id="actividad" value="{{ $tarea->actividad }}" readonly>

        </div>
    </div>

    <div class="row g-2">
        <div class="col mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea class="form-control" id="descripcion" rows="3" readonly>{{ $tarea->descripcion }}</textarea>
        </div>

        <div class="col md">
            <label for="historial" class="form-label">Historial</label>
            <textarea class="form-control" id="historial" rows="3" readonly>{{ $tarea->historial }}</textarea>
        </div>
    </div>

    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
        <a href="{{ url()->previous() }}" class="btn btn-secondary">Volver</a>
    </div>
</div>

@endsection
