@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="h5 mb-0">
                    <i class="fas fa-archive me-2"></i>Historias Archivadas
                </h2>
                <a href="{{ url()->previous() }}" class="btn btn-sm btn-light">
                    <i class="fas fa-arrow-left me-1"></i> Volver
                </a>
            </div>
        </div>
        
        <div class="card-body">
            @if($historiasArchivadas->isEmpty())
                <div class="text-center py-5">
                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                    <h4 class="text-muted">No hay historias archivadas</h4>
                    <p class="text-muted">Todas tus historias están activas actualmente</p>
                </div>
            @else
                <div class="list-group list-group-flush">
                    @foreach($historiasArchivadas as $archivo)
                        <div class="list-group-item list-group-item-action">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="mb-1">{{ $archivo->historia->nombre }}</h5>
                                    <small class="text-muted">
                                        Archivada el {{ $archivo->created_at->format('d/m/Y H:i') }}
                                    </small>
                                </div>
                                <form action="{{ route('archivo.desarchivar', $archivo->historia_id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-primary" 
                                            title="Restaurar esta historia">
                                        <i class="fas fa-undo me-1"></i> Desarchivar
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
@endsection

@section('styles')
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
        background-color: var(--bs-primary);
        color: white;
    }
</style>
@endsection