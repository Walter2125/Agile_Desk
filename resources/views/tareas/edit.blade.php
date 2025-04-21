@extends('adminlte::page')

@section('title', 'Agile Desk')

@section('adminlte_css')
    <link rel="stylesheet" href="{{ asset('css/tareas.css') }}">
@endsection

@section('Mensaje')
    <li class="nav-item d-flex align-items-center ps-3 mensaje-titulo">
        <span class="titulo-formulario">
            Editar tarea
        </span>
    </li>
@endsection

@section('content')
@if ($errors->any())
    <div id="mi_alerta" class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif



<div class="container-fluid contenedor-formulario">

    <form action="{{ route('tareas.update', $tarea->id) }}" method="POST">
        @csrf
        @method('PATCH')

        <div class="col md">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre', $tarea->nombre) }}" placeholder="Ingrese el nombre">
        </div>
       

        <div class="row g-2">
                    <div class="col md-3">
                        <label for="historia_nombre" class="form-label">Historia Asociada</label>
                        <input type="text" class="form-control" id="historia_nombre" value="{{ $tarea->historia->nombre }}" readonly>
                     </div>
            

            <div class="col md">
                <label for="asignado" class="form-label">Asignado a</label>
                <input type="text" class="form-control" id="asignado" name="asignado" value="{{ old('asignado', $tarea->asignado) }}">
            </div>

            <div class="col-md-4">
                <div class="container mt-4">
                    <label for="actividad" class="form-label">Actividad</label>
                    <select class="form-select" id="actividad" name="actividad" required>
                        <option value="Configuracion" {{ $tarea->actividad == 'Configuracion' ? 'selected' : '' }}>Configuración</option>
                        <option value="Desarrollo" {{ $tarea->actividad == 'Desarrollo' ? 'selected' : '' }}>Desarrollo</option>
                        <option value="Prueba" {{ $tarea->actividad == 'Prueba' ? 'selected' : '' }}>Prueba</option>
                        <option value="Diseño" {{ $tarea->actividad == 'Diseño' ? 'selected' : '' }}>Diseño</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="row g-2">
            <div class="col mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea class="form-control" id="descripcion" name="descripcion" rows="3">{{ old('descripcion', $tarea->descripcion) }}</textarea>
            </div>

            <div class="col md">
                <label for="historial" class="form-label">Historial</label>
                <textarea class="form-control" id="historial" name="historial" rows="3">{{ old('historial', $tarea->historial) }}</textarea>
            </div>
        </div>


        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <div class="row mb-3">
                <div class="col-md">
                <a href="{{ route('tareas.index') }}" class="btn btn-secondary me-2">Volver</a>
                <button class="btn btn-primary boton-guardar" type="submit">Actualizar</button>
                
                </div>
                </div>
            </div>

    </form>
</div>
@endsection

