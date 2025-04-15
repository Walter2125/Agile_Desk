@extends('adminlte::page')

    @section('adminlte_css')
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @stop
@section('content')
    <div class="container mt-5">
        <h1>Mis Proyectos:</h1>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card text-center create-project-card">
                    <div class="card-body">
                        <h5 class="card-title">Crear Nuevo Proyecto</h5>
                        <p class="card-text">Haz clic para crear un nuevo proyecto.</p>
                        <a href="{{ route('projects.create') }}" class="btn btn-success">
                            <i class="fas fa-plus"></i> Crear Proyecto
                        </a>
                    </div>
                </div>
            </div>
        </div>

        @if(count($projects) > 0)
            <div class="row">
                @foreach($projects as $project)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 d-flex flex-column ">
                            <div class="card-body carddelproy" data-project-id="{{ $project->id }}">
                                <h3>{{ $project->name }}</h3>
                                <p>Fecha de inicio: {{ $project->fecha_inicio }}</p>
                                <p>Fecha de finalización: {{ $project->fecha_fin }}</p>

                                <h5>
                                    Integrantes:
                                    <button class="btn btn-link btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#members{{ $project->id }}" aria-expanded="false" aria-controls="members{{ $project->id }}">
                                        Ver Miembros
                                    </button>
                                </h5>

                                <div class="collapse" id="members{{ $project->id }}">
                                    <ul>
                                        @foreach($project->users as $user)
                                            <li>{{ $user->name }}</li>
                                        @endforeach
                                    </ul>
                                </div>

                                <a href="" class="btn btn-info btn-sm mt-3">
                                    <i class="fas fa-eye"></i> Ver Proyecto
                                </a>

                                @if(auth()->id() === $project->user_id)
                                    <!-- Botón de editar proyecto -->
                                    <a href="{{ route('projects.edit', $project->id) }}" class="btn btn-warning btn-sm mt-3">
                                        <i class="fas fa-pencil-alt"></i> Editar Proyecto
                                    </a>

                                    <!-- Botón que abre el modal de confirmación -->
                                    <button class="btn btn-danger btn-sm mt-3" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal{{ $project->id }}">
                                        <i class="fas fa-trash"></i> Eliminar Proyecto
                                    </button>

                                    <!-- Modal de confirmación de eliminación -->
                                    <div class="modal fade" id="confirmDeleteModal{{ $project->id }}" tabindex="-1" aria-labelledby="confirmDeleteModalLabel{{ $project->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="confirmDeleteModalLabel{{ $project->id }}">Confirmar Eliminación</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    ¿Estás seguro de que deseas eliminar el proyecto <strong>{{ $project->name }}</strong>?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                    <form action="{{ route('projects.destroy', $project->id) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Eliminar Proyecto</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p>No estás asociado a ningún proyecto.</p>
        @endif
    </div>
@endsection

@section('adminlte_js')
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/color.js') }}"></script>
@stop
