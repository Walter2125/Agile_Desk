@extends('adminlte::page')

@section('content')
    <div class="container mt-5">
        <h1>Crear Proyecto</h1>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('projects.store') }}" method="POST">
            @csrf

            <!-- Nombre del Proyecto -->
            <div class="mb-3">
                <label for="name" class="form-label">Nombre del Proyecto</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>

            <!-- Fechas -->
            <div class="mb-3">
                <label for="fecha_inicio" class="form-label">Fecha de Inicio</label>
                <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" required>
            </div>

            <div class="mb-3">
                <label for="fecha_fin" class="form-label">Fecha de Fin</label>
                <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" required>
            </div>

            <!-- Selección de Usuarios -->
            <div class="mb-3">
                <label for="users" class="form-label">Seleccionar Usuarios</label>

                <!-- Campo de Búsqueda -->
                <div id="user_list">
                    @foreach($users as $user)
                        <!-- No mostramos al usuario autenticado -->
                        @if ($user->id !== auth()->id())
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="users[]" value="{{ $user->id }}" id="user{{ $user->id }}">
                                <label class="form-check-label" for="user{{ $user->id }}">{{ $user->name }}</label>
                            </div>
                        @endif
                    @endforeach
                </div>

                <small class="form-text text-muted">Selecciona uno o más usuarios para asignar al proyecto.</small>
            </div>

            <!-- Botón para Guardar Proyecto -->
            <button type="submit" class="btn btn-primary mt-3">Guardar Proyecto</button>
        </form>
    </div>

    <!-- Estilos CSS para Mejorar el Estilo -->
    <style>
        #user_list .form-check {
            margin-bottom: 10px;
        }

        #user_list {
            max-height: 200px;
            overflow-y: auto;
        }

        #user_search {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
    </style>
@endsection