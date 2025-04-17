@extends('adminlte::page')

@section('adminlte_css')
    <link rel="stylesheet" href="{{ asset('style.css') }}">
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

            <!-- Selección de Usuarios -->
             <!-- Campo de búsqueda de usuarios -->
            <div class="mb-3">
                <label for="user_search" class="form-label">Buscar Usuarios</label>
                <input type="text" class="form-control" id="user_search" placeholder="Buscar por nombre...">
                            </div>
                            
            <!-- Lista de resultados de búsqueda de usuarios -->
            <div id="user_list">

            <!-- Aquí se mostrarán los resultados de búsqueda -->
                        </div>

            <!-- Este div será contenedor para los inputs dinámicos -->
<div id="users-container"></div>


            <div>
                <!-- Tabla de usuarios seleccionados -->
<h3>Usuarios Seleccionados</h3>
<table class="table table-bordered" id="selected_users_table">
    <thead>
                                            <tr>
            <th>Nombre</th>
            <th>Acción</th>
                                            </tr>
                                        </thead>
                                        <tbody>
        <!-- Aquí se agregarán los usuarios seleccionados -->
                                        </tbody>
                                    </table>

            </div>


            <!-- Botón para Guardar Proyecto -->
            <button type="submit" class="btn btn-primary mt-3">Guardar Proyecto</button>
        </form>
    </div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        $('#user_search').on('input', function() {
            var query = $(this).val();

            if (query.length > 2) {
                $.ajax({
                    url: "{{ route('projects.searchUsers') }}",
                    type: 'GET',
                    data: { query: query },
                    success: function(data) {
                    $('#user_list').empty();

                        if (data.length > 0) {
                            data.forEach(function(user) {
                                var userHtml = `
                                <div class="form-check">
                                    <label class="form-check-label">${user.name}</label>
                                    <button type="button" class="btn btn-success btn-sm add-user" data-user-id="${user.id}" data-user-name="${user.name}">Añadir</button>
                                    </div>
                                `;
                            $('#user_list').append(userHtml);
                            });
                        } else {
                        $('#user_list').append('<p>No se encontraron usuarios</p>');
                        }
                    }
                });
            } else {
            $('#user_list').empty();
            }
        });

        // Agregar usuario a la tabla
        $(document).on('click', '.add-user', function() {
            var userId = $(this).data('user-id');
            var userName = $(this).data('user-name');

        // Evitar duplicados en la tabla
            if ($('#selected_users_table tbody tr[data-user-id="'+ userId +'"]').length === 0) {
                var rowHtml = `
                    <tr data-user-id="${userId}">
                    <td>${userName}</td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm remove-user" data-user-id="${userId}">Eliminar</button>
                        </td>
                    </tr>
                `;
                $('#selected_users_table tbody').append(rowHtml);
            }
        });

        // Eliminar usuario de la tabla
        $(document).on('click', '.remove-user', function() {
            var userId = $(this).data('user-id');
            $('tr[data-user-id="'+ userId +'"]').remove();
        });

        $('form').on('submit', function(e) {
    e.preventDefault(); // Temporalmente previene el envío para verificar
            
    // Limpiar inputs anteriores si existen
            $('input[name="users[]"]').remove();
            
    // Recoger los usuarios seleccionados
            var selectedUsers = [];
    $('#selected_users_table tbody tr').each(function() {
                selectedUsers.push($(this).data('user-id'));
            });
            
    // Verificar que hay al menos un usuario seleccionado
            if (selectedUsers.length === 0) {
                alert('Debes seleccionar al menos un usuario');
                return false;
            }
            
    // Crear inputs ocultos para cada usuario
            selectedUsers.forEach(function(userId) {
                $('<input>').attr({
                    type: 'hidden',
                    name: 'users[]',
                    value: userId
                }).appendTo('form');
            });
            
    // Ahora sí enviar el formulario
            this.submit();
        });
    });

</script>


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

@section('adminlte_js')
    <script src="{{ asset('color.js') }}"></script>
@stop