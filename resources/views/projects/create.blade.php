@extends('layouts.app')

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

        <!-- Número del Sprint -->
                            <div class="mb-3">
                                <label for="sprint_number" class="form-label">Número de Sprint</label>
                                <input type="number" class="form-control" id="sprint_number" name="sprint_number" required>
                            </div>

        <!-- Buscador de Usuarios -->
                            <div class="mb-3">
                                <label for="user_search" class="form-label">Buscar Usuarios</label>
            <input type="text" class="form-control" id="user_search" placeholder="Escriba un nombre...">
            <div id="user_results" class="list-group mt-2"></div>
                            </div>

        <!-- Botón para Añadir Miembro -->
        <button type="button" id="add_member" class="btn btn-success">Añadir Miembro</button>

        <!-- Tabla de Usuarios Seleccionados -->
        <div class="mt-4">
                                <h4>Usuarios Seleccionados</h4>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Acción</th>
                                        </tr>
                                    </thead>
                                    <tbody id="selected_users"></tbody>
                                </table>
                            </div>

        <!-- Input Oculto para Enviar IDs -->
                            <input type="hidden" name="users" id="users">

        <!-- Botón para Guardar Proyecto -->
        <button type="submit" class="btn btn-primary mt-3">Guardar Proyecto</button>
                        </form>
                    </div>

<!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
        let selectedUsers = [];

        // Buscar Usuarios
            $('#user_search').on('input', function () {
                let query = $(this).val();
                if (query.length >= 2) {
                    $.ajax({
                        url: "{{ route('users.search') }}",
                        method: 'GET',
                        data: { query: query },
                        success: function (data) {
                            $('#user_results').html(data);
                        }
                    });
                } else {
                    $('#user_results').html('');
                }
            });

        // Añadir Usuario a la Tabla Temporal
            $(document).on('click', '.add-user', function () {
                let userId = $(this).data('id');
                let userName = $(this).data('name');

            if (!selectedUsers.includes(userId)) {
                selectedUsers.push(userId);
                let userRow = `<tr data-id="${userId}">
                    <td>${userName}</td>
                    <td><button type="button" class="btn btn-danger btn-sm remove-user">Eliminar</button></td>
                </tr>`;
                $('#selected_users').append(userRow);
                updateUsersInput();
            }
            });

        // Eliminar Usuario de la Tabla Temporal
            $(document).on('click', '.remove-user', function () {
            let row = $(this).closest('tr');
            let userId = row.data('id');
            selectedUsers = selectedUsers.filter(id => id !== userId);
            row.remove();
            updateUsersInput();
            });

        // Actualizar el Campo Oculto con los IDs de los Usuarios Seleccionados
            function updateUsersInput() {
            $('#users').val(selectedUsers.join(','));
            }
        });
    </script>
@endsection
