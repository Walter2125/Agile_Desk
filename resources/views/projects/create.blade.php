@extends('adminlte::page')

@section('title', 'Crear Nuevo Proyecto')

@section('adminlte_css')
    <link rel="stylesheet" href="{{ asset('css/css2.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sprints.css') }}">
    <link rel="stylesheet" href="{{ asset('css/flatpickr.min.css') }}">  
    <style>
        /* Eliminar todos los fondos azules */
        body, html {
            background-color: white !important;
            height: 100%;
        }
        
        .wrapper {
            background-color: transparent !important;
            height: 100%;
        }
        
        .content-wrapper {
            background-color: transparent !important;
            padding: 0 !important;
            margin: 0 !important;
            margin-left: 250px !important; /* Ajustar para el menú lateral */
            min-height: 100% !important;
        }
        
        /* Ajustes para el formulario */
        .project-dashboard {
            padding: 20px;
            width: 100%;
            height: 100%;
        }
        
        .create-project-form {
            background: white;
            padding: 30px;
            width: 100%;
            min-height: 100vh;
            box-sizing: border-box;
        }

        /* Resto de tus estilos originales */
        .form-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .form-header h1 {
            color: #1E3C72;
            font-weight: 600;
            font-size: 2rem;
            margin-bottom: 10px;
        }

        .form-header p {
            color: #546E7A;
            font-size: 1rem;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #455A64;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            border-radius: 8px;
            border: 1px solid #CFD8DC;
            font-family: 'Poppins', sans-serif;
            font-size: 1rem;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        .form-control:focus {
            border-color: #2196F3;
            box-shadow: 0 0 0 3px rgba(33, 150, 243, 0.25);
            outline: none;
        }

        textarea.form-control {
            min-height: 120px;
            resize: vertical;
        }

        .form-row {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }

        .form-row .form-group {
            flex: 1 1 300px;
        }

        .btn-container {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
        }

        .btn {
            padding: 12px 30px;
            border-radius: 8px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
            border: none;
            font-size: 1rem;
        }

        .btn-primary {
            background: #1976D2;
            color: white;
        }

        .btn-primary:hover {
            background: #1565C0;
            box-shadow: 0 4px 12px rgba(25, 118, 210, 0.3);
        }

        .btn-secondary {
            background: #78909C;
            color: white;
        }

        .btn-secondary:hover {
            background: #607D8B;
            box-shadow: 0 4px 12px rgba(120, 144, 156, 0.3);
        }

        .error-message {
            color: #F44336;
            font-size: 0.85rem;
            margin-top: 5px;
        }

        .card {
            border: none;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }

        .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #eee;
            border-radius: 8px 8px 0 0 !important;
        }

        .card-title {
            margin: 0;
            font-size: 1.1rem;
            color: #333;
        }

        .table {
            width: 100%;
            margin-bottom: 0;
        }

        .table th {
            border-top: none;
            font-weight: 600;
            color: #555;
        }

        .table td, .table th {
            vertical-align: middle;
            padding: 12px 15px;
        }

        .user-checkbox {
            width: 18px;
            height: 18px;
        }

        #user_search {
            width: 100%;
            padding: 12px 15px;
            border-radius: 8px;
            border: 1px solid #CFD8DC;
            font-family: 'Poppins', sans-serif;
            font-size: 1rem;
            margin-bottom: 20px;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        #user_search:focus {
            border-color: #2196F3;
            box-shadow: 0 0 0 3px rgba(33, 150, 243, 0.25);
            outline: none;
        }

        .pagination {
            justify-content: center;
        }

        .page-item.active .page-link {
            background-color: #1976D2;
            border-color: #1976D2;
        }

        .page-link {
            color: #1976D2;
            border-radius: 8px;
            margin: 0 5px;
            border: 1px solid #CFD8DC;
        }

        .page-link:hover {
            color: #1565C0;
            background-color: #f8f9fa;
        }
    </style>
@endsection

@section('content')
<div class="project-dashboard">
    <div class="create-project-form">
        <div class="form-header">
            <h1>🏗️ Crear Nuevo Proyecto</h1>
            <p>Complete el formulario para añadir un nuevo proyecto</p>
        </div>

        <form id="projectForm" action="{{ route('projects.store') }}" method="POST">
            @csrf

            <!-- Nombre del Proyecto -->
            <div class="form-group">
                <label for="name" class="form-label">Nombre del Proyecto <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" required>
                @error('name')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <!-- Fechas -->
            <div class="form-row">
                <div class="form-group">
                    <label for="fecha_inicio" class="form-label">Fecha de Inicio <span class="text-danger">*</span></label>
                    <input type="date" class="form-control @error('fecha_inicio') is-invalid @enderror" id="fecha_inicio" name="fecha_inicio" required>
                    @error('fecha_inicio')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="fecha_fin" class="form-label">Fecha de Fin <span class="text-danger">*</span></label>
                    <input type="date" class="form-control @error('fecha_fin') is-invalid @enderror" id="fecha_fin" name="fecha_fin" required>
                    @error('fecha_fin')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Campo de búsqueda -->
            <div class="form-group">
                <label for="user_search" class="form-label">Buscar Usuarios</label>
                <input type="text" class="form-control" id="user_search" placeholder="Buscar por nombre...">
            </div>

            <!-- Tabla de usuarios -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Lista de Usuarios</h3>
                </div>
                <div class="card-body">
                    <div id="users-container">
                        @include('projects.partials.users_table', ['users' => $users])
                    </div>
                    <div id="pagination-container" class="d-flex justify-content-center mt-3">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>

            <!-- Campo oculto para IDs de usuarios -->
            <input type="hidden" id="selected_users" name="users">

            <div class="btn-container">
                <a href="{{ route('projects.my') }}" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary" id="submitBtn">Guardar Proyecto</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('adminlte_js')
    <script src="{{ asset('js/flatpickr.js') }}"></script> 
    <script src="{{ asset('js/es.js') }}"></script> 
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {
        let selectedUsers = {};

        loadSavedData();
        bindUserCheckboxes();

        function bindUserCheckboxes() {
            $('.user-checkbox').off('change').on('change', function() {
                const userId = $(this).val();
                selectedUsers[userId] = $(this).is(':checked');
                updateSelectedUsersField();
                saveToLocalStorage();
            });

            $('.user-checkbox').each(function() {
                const userId = $(this).val();
                if (selectedUsers[userId]) {
                    $(this).prop('checked', true);
                }
            });
        }

        function updateSelectedUsersField() {
            const selectedIds = Object.keys(selectedUsers).filter(id => selectedUsers[id]);
            $('#selected_users').val(selectedIds.join(','));
        }

        function saveToLocalStorage() {
            const formData = {
                name: $('#name').val(),
                fecha_inicio: $('#fecha_inicio').val(),
                fecha_fin: $('#fecha_fin').val(),
                selectedUsers: selectedUsers
            };
            localStorage.setItem('projectFormData', JSON.stringify(formData));
        }

        function loadSavedData() {
            const saved = localStorage.getItem('projectFormData');
            if (saved) {
                const data = JSON.parse(saved);
                $('#name').val(data.name);
                $('#fecha_inicio').val(data.fecha_inicio);
                $('#fecha_fin').val(data.fecha_fin);
                selectedUsers = data.selectedUsers || {};
                updateSelectedUsersField();
            }
        }

        // Buscador en tiempo real
        $('#user_search').on('input', function() {
            loadUsers(1, $(this).val());
        });

        // Paginación
        $(document).on('click', '.pagination a', function(e) {
            e.preventDefault();
            const page = $(this).attr('href').split('page=')[1];
            loadUsers(page, $('#user_search').val());
        });

        function loadUsers(page, search = '') {
            $.ajax({
                url: '{{ route("users.list") }}?page=' + page + '&search=' + search,
                type: 'GET',
                success: function(response) {
                    $('#users-container').html(response.html);
                    $('#pagination-container').html(response.pagination);
                    bindUserCheckboxes();
                }
            });
        }

        $('input[name="name"], input[name="fecha_inicio"], input[name="fecha_fin"]').on('change', function() {
            saveToLocalStorage();
        });

        $('#projectForm').on('submit', function(e) {
            e.preventDefault();
            updateSelectedUsersField();

            $('#submitBtn').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Guardando...');

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    localStorage.removeItem('projectFormData');
                    window.location.href = response.redirect;
                },
                error: function(xhr) {
                    $('#submitBtn').prop('disabled', false).html('Guardar Proyecto');
                    const errors = xhr.responseJSON.errors;
                    let messages = [];
                    for (let field in errors) {
                        messages.push(errors[field][0]);
                    }
                    alert('Error: ' + messages.join('\n'));
                }
            });
        });
    });
    </script>
    <script src="{{ asset('js/color.js') }}"></script>
@stop