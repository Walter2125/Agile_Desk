@extends('adminlte::page')

@section('adminlte_css')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
@stop
    
@section('content')
    <div class="container mt-5">
        <h1 class="text-primary mb-4">Mis Proyectos</h1>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <!-- Tarjeta para crear nuevo proyecto -->
        <div class="row mb-5">
            <div class="col-md-4">
                <div class="card text-center create-project-card">
                    <div class="card-body p-4">
                        <h4 class="card-title font-weight-bold text-dark">Crear Nuevo Proyecto</h4>
                        <p class="card-text text-muted">Comienza un nuevo proyecto colaborativo</p>
                        <a href="{{ route('projects.create') }}" class="btn btn-primary btn-lg rounded-pill px-4">
                            <i class="fas fa-plus mr-2"></i> Crear Proyecto
                        </a>
                    </div>
                </div>
            </div>
        </div>

        @if(count($projects) > 0)
        <h2 class="text-secondary mb-4 border-bottom pb-2">Proyectos Recientes</h2>
            <div class="row">
                @foreach($projects as $project)
                    <div class="col-md-4 mb-4">
                        <div class="card project-card h-100 d-flex flex-column">
                                <div class="row mb-3">
                                    <div class="col-md">       
                                        <div class="card-header bg-white border-0 pt-3 d-flex justify-content-between align-items-center">
                                            <h3 class="card-title font-weight-bold text-dark m-0 d-flex align-items-center">
                                                <i class="fas fa-project-diagram text-primary mr-2"></i>
                                                {{ $project->name }}
                                            </h3>
                                            <a href="{{ route('sprints.create') }}" class="btn btn-primary btn-lg rounded-pill px-4">
                                                <i class="fas fa-plus mr-2"></i> Crear Sprint
                                            </a>
                                        </div>
                                    </div>
                                </div>

                            <div class="card-body">
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
                            
                            <div class="card-footer bg-white border-0 pb-3">
                                <div class="d-flex justify-content-between">
                                <a href="{{ route('sprints.index') }}" class="btn btn-outline-info btn-sm rounded-pill" aria-label="Crear nuevo sprint"> <i class="fas fa-eye mr-1"></i>ver</a>
                                    

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
                                <div class="modal-header bg-light">
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
                                <div class="modal-footer border-0">
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
            <div class="empty-state text-center py-5">
                <i class="fas fa-folder-open fa-4x text-muted mb-3"></i>
                <h3 class="text-secondary">No tienes proyectos aún</h3>
                <p class="text-muted">Crea tu primer proyecto para comenzar a colaborar</p>
                <a href="{{ route('projects.create') }}" class="btn btn-primary mt-3">
                    <i class="fas fa-plus mr-2"></i> Crear Primer Proyecto
                </a>
            </div>
        @endif
    </div>

    <style>
        /* Estilos personalizados */
        .create-project-card {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 15px;
            transition: all 0.3s ease;
            border: 1px dashed #adb5bd;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
        }
        
        .create-project-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
            border-color: #4e73df;
        }
        
        .project-card {
            border-radius: 12px;
            transition: all 0.3s ease;
            border: 1px solid rgba(0,0,0,0.05);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
        }
        
        .project-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        
        .hover-effect {
            transition: all 0.3s ease;
        }
        
        .hover-effect:hover {
            transform: translateY(-3px);
        }
        
        .empty-state {
            background-color: #f8f9fa;
            border-radius: 15px;
            padding: 40px;
        }
        
        .btn-rounded {
            border-radius: 50px;
        }
        
        .team-section {
            background-color: #f8fafc;
            padding: 15px;
            border-radius: 10px;
        }
        
        /* Estilos para los modales */
        .modal-content {
            border-radius: 15px;
        }
        
        .modal-header {
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
        }
    </style>
@endsection

@section('adminlte_js')
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/color.js') }}"></script>

    <script>
        document.querySelectorAll('.btn-delete').forEach(button => {
            button.addEventListener('click', async () => {
                const projectId = button.dataset.projectId;
        
                if (!confirm('¿Estás seguro de eliminar este proyecto?')) return;
        
                try {
                    const response = await fetch(`/projects/${projectId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json'
                        }
                    });
        
                    const result = await response.json();
        
                    if (response.ok && result.success) {
                        alert(result.message);
                        location.reload(); // o elimina el div desde el DOM
                    } else {
                        alert(result.error || 'Error al eliminar el proyecto.');
                    }
        
                } catch (error) {
                    console.error(error);
                    alert('Ocurrió un error inesperado.');
                }
            });
        });
        </script>
        
@stop

