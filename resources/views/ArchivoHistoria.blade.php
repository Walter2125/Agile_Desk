@extends('adminlte::page')

@section('title', 'Agile Desk')

@section('content_header')
    <h1>Historias Archivadas</h1>
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

        .btn-outline-success:hover {
            background-color: #28a745;
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
                    <i class="fas fa-archive me-2"></i>Historias Archivadas
                </h2>
                <a href="{{ route('archivo.seleccionar') }}" class="btn btn-sm btn-light">
                    <i class="fas fa-box-open me-1"></i> Ver Activas
                </a>
            </div>
        </div>

        <div class="card-body">
            @if($historiasArchivadas->isEmpty())
                <div class="text-center py-5">
                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                    <h4 class="text-muted">No hay historias archivadas</h4>
                    <p class="text-muted">Puedes archivar historias desde el listado de historias activas.</p>
                </div>
            @else
                <div class="list-group list-group-flush">
                    @foreach($historiasArchivadas as $registro)
                        @php
                            $historia = $registro->historia;
                        @endphp
                        <div class="list-group-item list-group-item-action">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="mb-1">{{ $historia->nombre }}</h5>
                                    <small class="text-muted">Archivada en: {{ \Carbon\Carbon::parse($registro->archivado_en)->format('d/m/Y H:i') }}</small>
                                </div>
                                <form method="POST" action="{{ route('archivo.desarchivar', $historia->id) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-success" title="Restaurar historia">
                                        <i class="fas fa-undo me-1"></i> Restaurar
                                    </button>
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