@extends('adminlte::page')

@section('adminlte_css')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
@stop

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

            <!-- Campo de búsqueda de usuarios -->
            <div class="mb-3">
                <label for="user_search" class="form-label">Buscar Usuarios</label>
                <input type="text" class="form-control" id="user_search" placeholder="Buscar por nombre...">
            </div>

            <!-- Tabla de usuarios -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Lista de Usuarios</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped" id="users_table">
                        <thead>
                            <tr>
                                <th>Seleccionar</th>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Rol</th>
                                <th>Fecha de creación</th>
                            </tr>
                        </thead>
                        <tbody id="user_list">
                            @foreach ($users as $user)
                                <tr>
                                    <td>
                                        <input type="checkbox" name="users[]" value="{{ $user->id }}">
                                    </td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        <span class="badge bg-{{ $user->role == 'admin' ? 'danger' : 'primary' }}">
                                            {{ $user->role }}
                                        </span>
                                    </td>
                                    <td>{{ $user->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Botón para Guardar Proyecto -->
            <button type="submit" class="btn btn-primary mt-3">Guardar Proyecto</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#user_search').on('input', function() {
                var query = $(this).val().toLowerCase();
                $('#user_list tr').each(function() {
                    var name = $(this).find('td:nth-child(2)').text().toLowerCase();
                    if (name.includes(query)) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });
        });
    </script>

    <style>
        #user_search {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
    </style>
@endsection

@section('adminlte_js')
    <script src="{{ asset('js/color.js') }}"></script>
@stop
