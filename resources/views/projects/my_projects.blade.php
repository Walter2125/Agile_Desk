@extends('adminlte::page')

@section('adminlte_css')
    <link rel="stylesheet" href="{{ asset('style.css') }}">
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
                        <div class="card h-100 d-flex flex-column">
                            <div class="card-body">
                                <h3>{{ $project->name }}</h3>
                                <p></p>
                                <p></p>
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('color.js') }}"></script>
@stop
