@extends('adminlte::page')

@section('content')
    <div class="container mt-5">
        <h1>Editar Proyecto: {{ $project->name }}</h1>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('projects.update', $project->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Nombre del Proyecto -->
            <div class="mb-3">
                <label for="name" class="form-label">Nombre del Proyecto</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $project->name) }}" required>
            </div>

            <!-- Fechas -->
            <div class="mb-3">
                <label for="fecha_inicio" class="form-label">Fecha de Inicio</label>
                <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" value="{{ old('fecha_inicio', $project->fecha_inicio) }}" required>
            </div>

            <div class="mb-3">
                <label for="fecha_fin" class="form-label">Fecha de Fin</label>
                <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" value="{{ old('fecha_fin', $project->fecha_fin) }}" required>
            </div>

            <!-- Dueño del Proyecto (Administrador) -->
            <div class="mb-3">
                <label class="form-label">Administrador del Proyecto</label>
                <div class="form-check">
                    <label class="form-check-label">
                        {{ $project->creator->name }}
                    </label>
                </div>
            </div>

            <!-- Selección de Usuarios -->
   
            
            <div id="current_users">
    @foreach($project->users as $user)
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="users[]" value="{{ $user->id }}" id="user{{ $user->id }}" checked>
            <label class="form-check-label" for="user{{ $user->id }}">{{ $user->name }}</label>
            
            <!-- Botón de eliminar miembro -->
            <button type="button" class="btn btn-danger btn-sm remove-user" data-user-id="{{ $user->id }}" data-project-id="{{ $project->id }}">Eliminar</button>
        </div>
    @endforeach
</div>


            <!-- Botón para Guardar Proyecto -->
            <button type="submit" class="btn btn-primary mt-3">Actualizar Proyecto</button>
        </form>
    </div>


    <script>
    $(document).on('click', '.remove-user', function() {
        var userId = $(this).data('user-id');
        var projectId = $(this).data('project-id');

        $.ajax({
            url: '/projects/' + projectId + '/remove-user/' + userId,
            type: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}',
            },
            success: function(response) {
                if (response.success) {
                    // Eliminar el miembro del DOM
                    $('button[data-user-id="'+ userId +'"]').parent().remove();
                    alert('Usuario eliminado exitosamente');
                } else {
                    alert('Error al eliminar al usuario');
                }
            }
        });
    });
</script>


    <style>
        #user_list .form-check {
            margin-bottom: 10px;
        }

        #user_list {
            max-height: 200px;
            overflow-y: auto;
        }
    </style>
@endsection