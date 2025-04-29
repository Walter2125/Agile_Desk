@extends('adminlte::page')

@section('title', 'Mis Historias')

@section('content_header')
    <h1>📚 Mis Historias Asignadas</h1>
    <p class="lead">Revisa las historias que tienes a tu cargo</p>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            @if($historias->isEmpty())
                <div class="empty-message text-center py-5">
                    <p class="text-muted" style="font-size: 1.25rem;">😴 Aún no tienes historias asignadas. ¡Hora de crear algo increíble!</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle text-center">
                        <thead class="thead-light">
                            <tr>
                                <th>📝 Nombre</th>
                                <th>👤 Responsable</th>
                                <th>🚀 Sprint</th>
                                <th>📅 Fecha de creación</th>
                                <th>🔴 Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($historias as $historia)
                                <tr>
                                    <td><strong>{{ $historia->nombre }}</strong></td>
                                    <td>{{ $historia->responsable }}</td>
                                    <td>{{ $historia->sprint }}</td>
                                    <td>{{ $historia->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        @if($historia->estado == 'Pendiente')
                                            <span class="badge bg-warning">Pendiente</span>
                                        @elseif($historia->estado == 'En progreso')
                                            <span class="badge bg-info">En progreso</span>
                                        @elseif($historia->estado == 'Completada')
                                            <span class="badge bg-success">Completada</span>
                                        @else
                                            <span class="badge bg-secondary">{{ $historia->estado ?? 'Sin estado' }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
            
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        .empty-message {
            padding: 3rem;
        }
        .card {
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            border-radius: 10px;
        }
        .table thead {
            background-color: #f8f9fa;
        }
        .lead {
            color: #6c757d;
            font-size: 1.1rem;
        }
        .badge {
            font-size: 0.9rem;
            padding: 0.35em 0.65em;
        }
    </style>
@stop

@section('js')
    <script>
        // Puedes agregar scripts específicos para esta vista aquí si es necesario
        console.log('Vista de historias cargada');
    </script>
@stop