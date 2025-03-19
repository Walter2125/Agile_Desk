@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1>Lista de Proyectos</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
        @foreach($projects as $project)
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">{{ $project->name }}</h5>
                        <p class="card-text">Sprint Número: {{ $project->sprint_number }}</p>
                        <p class="card-text">Usuarios: {{ implode(', ', $project->users->pluck('name')->toArray()) }}</p>
                        <a href="{{ route('projects.edit', $project->id) }}" class="btn btn-warning">Editar</a>
                        <form action="{{ route('projects.destroy', $project->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de eliminar este proyecto?')">Eliminar</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
