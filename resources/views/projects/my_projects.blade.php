@extends('adminlte::page')

@section('content')
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-secondary mb-0">Proyectos Recientes</h2>
            <a href="{{ route('projects.create') }}" class="btn btn-primary">
                <i class="fas fa-plus mr-2"></i> Nuevo Proyecto
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if(count($projects) > 0)
            <div class="row mt-4">
                @foreach($projects as $project)
                    <div class="col-md-4 mb-4">
                        <div class="card project-card h-100 d-flex flex-column">
                            <div class="card-header bg-white border-bottom pt-3">
                                <h3 class="card-title font-weight-bold text-dark">
                                    <i class="fas fa-project-diagram text-primary mr-2"></i>
                                    {{ $project->name }}
                                </h3>
                            </div>
                            <div class="card-body bg-white">
                                <div class="project-meta mb-3">
                                    <p class="mb-1">
                                        <i class="far fa-calendar-alt text-muted mr-2"></i>
                                        <span class="font-weight-bold">Inicio:</span> 
                                        <span class="text-dark">{{ $project->fecha_inicio }}</span>
                                    </p>
                                    <p>
                                        <i class="far fa-calendar-check text-muted mr-2"></i>
                                        <span class="font-weight-bold">Fin:</span> 
                                        <span class="text-dark">{{ $project->fecha_fin }}</span>
                                    </p>
                                </div>

                                <div class="team-section mb-3">
                                    <h5 class="d-flex align-items-center">
                                        <i class="fas fa-users text-info mr-2"></i>
                                        <span>Integrantes</span>
                                        <button class="btn btn-link btn-sm ml-auto p-0" type="button" data-bs-toggle="collapse" data-bs-target="#members{{ $project->id }}" aria-expanded="false" aria-controls="members{{ $project->id }}">
                                            <i class="fas fa-chevron-down"></i>
                                        </button>
                                    </h5>

                                    <div class="collapse" id="members{{ $project->id }}">
                                        <ul class="list-group list-group-flush">
                                            @foreach($project->users as $user)
                                                <li class="list-group-item d-flex align-items-center border-0 py-2">
                                                    <i class="fas fa-user-circle text-secondary mr-2"></i>
                                                    {{ $user->name }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="card-footer bg-white border-top pb-3">
                                <div class="d-flex justify-content-between">
                                    <a href="" class="btn btn-outline-info btn-sm rounded-pill">
                                        <i class="fas fa-eye mr-1"></i> Ver
                                    </a>

                                    @if(auth()->id() === $project->user_id)
                                        <a href="{{ route('projects.edit', $project->id) }}" class="btn btn-outline-warning btn-sm rounded-pill">
                                            <i class="fas fa-pencil-alt mr-1"></i> Editar
                                        </a>

                                        <button class="btn btn-outline-danger btn-sm rounded-pill" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal{{ $project->id }}">
                                            <i class="fas fa-trash mr-1"></i> Eliminar
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal de confirmación de eliminación -->
                    <div class="modal fade" id="confirmDeleteModal{{ $project->id }}" tabindex="-1" aria-labelledby="confirmDeleteModalLabel{{ $project->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content border-0 shadow">
                                <div class="modal-header bg-white">
                                    <h5 class="modal-title text-danger" id="confirmDeleteModalLabel{{ $project->id }}">
                                        <i class="fas fa-exclamation-triangle mr-2"></i> Confirmar Eliminación
                                    </h5>
                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p>¿Estás seguro de que deseas eliminar el proyecto <strong class="text-primary">{{ $project->name }}</strong>?</p>
                                    <p class="text-muted small">Esta acción no se puede deshacer.</p>
                                </div>
                                <div class="modal-footer border-0 bg-white">
                                    <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Cancelar</button>
                                    <form action="{{ route('projects.destroy', $project->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger rounded-pill px-4">
                                            <i class="fas fa-trash mr-1"></i> Eliminar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state text-center py-5 bg-white border rounded">
                <i class="fas fa-folder-open fa-4x text-muted mb-3"></i>
                <h3 class="text-secondary">No tienes proyectos aún</h3>
                <p class="text-muted">Crea tu primer proyecto para comenzar a colaborar</p>
                <a href="{{ route('projects.create') }}" class="btn btn-primary mt-3">
                    <i class="fas fa-plus mr-2"></i> Crear Primer Proyecto
                </a>
            </div>
        @endif
    </div>
@endsection

@push('css')
<style>
    /* Estilos personalizados */
    .project-card {
        border-radius: 10px;
        transition: all 0.3s ease;
        border: 1px solid #e0e0e0;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.03);
        background-color: #ffffff;
    }
    
    .project-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.08);
        border-color: #d0d0d0;
    }
    
    .empty-state {
        background-color: #ffffff;
        border: 1px solid #e0e0e0;
        border-radius: 10px;
        padding: 40px;
    }
    
    .team-section {
        background-color: #f8fafc;
        padding: 15px;
        border-radius: 8px;
    }
    
    body {
        background-color: #ffffff !important;
    }
    
    .container {
        background-color: transparent !important;
    }
</style>
@endpush

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>