@extends('adminlte::page')

@section('title', 'Agile Desk')

@section('Mensaje')
    <li class="nav-item d-flex align-items-center ps-3" style="padding-top: 0.4rem; padding-bottom: 0.4rem;">
        <span class="fw-bold" style="font-size: 2rem;">
            Detalles de la historia
        </span>
    </li>
@endsection

@section("adminlte_css")
    <link rel="stylesheet" href="{{ asset('css/cust.css') }}">
@endsection

@section('content')
<div class="container-fluid contenedor-con-borde">
    <div class="row g-2">
        <div class="col-md-3">
            <label class="label-custom"># Historia:</label>
            <input type="text" class="form-control input-custom" value="{{ $historia->id }}" readonly>
        </div>
        <div class="col-md">
            <label class="label-custom">Nombre de la historia:</label>
            <input type="text" class="form-control input-custom" value="{{ $historia->nombre }}" readonly>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-4">
            <label class="label-custom">Estado:</label>
            <input type="text" class="form-control input-custom" value="{{ $historia->estado ?? 'No especificado' }}" readonly>
        </div>
        <div class="col-md-4">
            <label class="label-custom">Sprint:</label>
            <input type="text" class="form-control input-custom" value="{{ $historia->sprint }}" readonly>
        </div>
        <div class="col-md-4">
            <label class="label-custom">Trabajo estimado (horas):</label>
            <input type="text" class="form-control input-custom" value="{{ $historia->trabajo_estimado }}" readonly>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <label class="label-custom">Responsable:</label>
            <input type="text" class="form-control input-custom" value="{{ $historia->responsable }}" readonly>
        </div>
        <div class="col-md-6">
            <label class="label-custom">Prioridad:</label>
            <input type="text" class="form-control input-custom" value="{{ $historia->prioridad }}" readonly>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md">
            <label class="label-custom">Descripción:</label>
            <textarea class="form-control input-custom" rows="3" readonly>{{ $historia->descripcion }}</textarea>
        </div>
    </div>

    >


    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <div class="row mb-3">
                <div class="col-md">
                <!--<a href="{{ route('tablero') }}" class="btn btn-secondary">Volver</a>-->
                <a href="{{ route('tareas.create',['historia_id' => $historia ->id]) }}" class="btn btn-primary"> Crear Tarea</a>
                <a href="{{ route('tareas.porHistoria', $historia->id) }}" class="btn btn-info">Ver Tareas</a>
                                
                
                </div>
                </div>
            </div>

</div>
@endsection
