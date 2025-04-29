@extends('adminlte::page')

@section('title', 'Crear Sprint')

@section('content')
<div class="container py-4">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title">Crear Nuevo Sprint</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('sprints.store') }}" method="POST">
                @csrf
                <input type="hidden" name="project_id" value="{{ request('project_id') }}">
                
                <div class="form-group">
                    <label for="nombre">Nombre del Sprint</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                </div>

                <div class="form-group">
                    <label for="fecha_inicio">Fecha de Inicio</label>
                    <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" required>
                </div>

                <div class="form-group">
                    <label for="fecha_fin">Fecha de Fin</label>
                    <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" required>
                </div>

                <div class="form-group">
                    <label for="color">Color</label>
                    <input type="color" class="form-control" id="color" name="color" value="#0d6efd">
                </div>

                <button type="submit" class="btn btn-primary">Crear Sprint</button>
                <a href="{{ url()->previous() }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</div>
@stop
