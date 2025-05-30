@extends('adminlte::page')

@section('title', 'Agile Desk')

@section('content_header')
    <h1>Seleccionar Historia para Archivar</h1>
@stop

@section('adminlte_css')
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <style>
        .list-group-item:hover {
            background-color: #f8f9fa;
            transform: translateX(2px);
            transition: all 0.2s ease;
        }

        .card {
            border-radius: 10px;
            border: none;
        }

        .card-header {
            border-radius: 10px 10px 0 0 !important;
        }

        .btn-outline-primary:hover {
            background-color: #007bff;
            color: white;
        }

        .btn-light:hover {
            background-color: #e2e6ea;
        }
    </style>
@stop

@section('content')
<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="h5 mb-0">
                    <i class="fas fa-tasks me-2"></i>Seleccionar Historia para Archivar
                </h2>
                <a href="{{ route('archivo.index.proyecto', ['project' => $project->id]) }}" class="btn btn-sm btn-light">
                                        <i class="fas fa-archive me-1"></i> Ver Archivadas
                </a>
            </div>
        </div>

        <div class="card-body">
            @if($historias->isEmpty())
                <div class="text-center py-5">
                    <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                    <h4 class="text-muted">No hay historias activas</h4>
                    <p class="text-muted">Todas las historias han sido archivadas.</p>
                </div>
            @else
                <div class="list-group list-group-flush">
                    @foreach($historias as $historia)
                        <div class="list-group-item list-group-item-action">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="mb-1">{{ $historia->nombre }}</h5>
                                </div>
                                <form action="{{ route('archivo.archivar', ['project' => $project->id, 'id' => $historia->id]) }}" method="POST">
    @csrf
    <button type="submit" class="btn btn-warning">Archivar</button>
</form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@stop