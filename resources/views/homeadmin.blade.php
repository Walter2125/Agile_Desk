@extends('adminlte::page')

@section('title', 'Panel de Administración - Agile Desk')

@section('adminlte_css')
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}"> 
    <style>
        #text {
            position: absolute;
            color: white;
            font-size: 3rem;
            font-weight: bold;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5);
            z-index: 10;
            width: 100%;
            text-align: center;
        }
        
        /* Estilos para el panel de administración */
        .admin-header {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            border-left: 4px solid #4a90e2;
        }
        
        .admin-card {
            margin-bottom: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        .admin-card .card-header {
            background-color: #f8f9fa;
            font-weight: bold;
        }

        .button-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 10px;
            margin-top: 20px;
            padding: 0 15px;
        }

        @media (min-width: 768px) {
            .button-container {
                justify-content: flex-end;
                padding-right: 20px;
            }
        }

        .button-container .btn {
            background: linear-gradient(to right, #6fb3f2, #4a90e2);
            border: none;
            color: white;
            padding: 8px 18px;
            font-size: 14px;
            font-weight: bold;
            border-radius: 6px;
            text-transform: uppercase;
            transition: all 0.3s ease-in-out;
            box-shadow: 1px 1px 8px rgba(0, 0, 0, 0.2);
            margin-bottom: 5px;
        }

        .button-container .btn:hover {
            background: linear-gradient(to right, #4a90e2, #357abd);
            transform: scale(1.05);
        }
        
        .quick-stats {
            text-align: center;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        
        .quick-stats .stat-number {
            font-size: 1.5rem;
            font-weight: bold;
            color: #4a90e2;
        }
        
        .quick-stats .stat-label {
            font-size: 0.9rem;
            color: #6c757d;
        }
        .card-body {
            background-color: #ffffff;
            color: #333333;
        }
        .admin-table th {
            background-color: #f8f9fa;
        }

        /* Estilos para paginación */
        .pagination-container {
            display: flex;
            justify-content: center;
            margin-top: 15px;
        }
        
        /* Modo oscuro para el panel de administración */
        /* === Modo oscuro global para cards === */
[data-theme="dark"] .card,
[data-theme="dark"] .admin-card,
[data-theme="dark"] .card-body {
  background-color: #2b2b2b !important;
  color: #e0e0e0 !important;
  box-shadow: 0 2px 5px rgba(0,0,0,0.5) !important;
}

/* Ajusta color de cabecera de las cards */
[data-theme="dark"] .card-header,
[data-theme="dark"] .admin-card .card-header {
  background-color: #333333 !important;
  color: #ffffff !important;
}

/* === Modo oscuro global para tablas === */
[data-theme="dark"] .table,
[data-theme="dark"] .admin-table,
[data-theme="dark"] .table-responsive {
  background-color: #2b2b2b;
  color: #e0e0e0;
}

/* Encabezados de tabla */
[data-theme="dark"] .table thead th {
  background-color: #333333;
  color: #ffffff;
  border-color: #444444;
}

/* Filas y celdas */
[data-theme="dark"] .table tbody td,
[data-theme="dark"] .table tbody tr {
  border-color: #3a3a3a;
  color: #e0e0e0;
  background-color: #2b2b2b;
}

/* Hover en filas */
[data-theme="dark"] .table-hover tbody tr:hover {
  background-color: rgba(255,255,255,0.05);
}

/* Si usas badges, botones o enlaces dentro de tablas/cards: */
[data-theme="dark"] .badge,
[data-theme="dark"] .btn,
[data-theme="dark"] a {
  color: #f1f1f1;
}

/* Optional: scrollbars oscuros en contenedores con overflow */
[data-theme="dark"] .table-responsive::-webkit-scrollbar {
  width: 8px;
}
[data-theme="dark"] .table-responsive::-webkit-scrollbar-thumb {
  background-color: #555;
  border-radius: 4px;
}

 /* Estilos para el buscador en modo claro */
 .input-group .form-control {
        border-radius: 0.25rem 0 0 0.25rem;
    }
    
    .input-group-append .btn {
        border-radius: 0 0.25rem 0.25rem 0;
    }
    
    /* Estilos para el buscador en modo oscuro */
    [data-theme="dark"] .input-group .form-control {
        background-color: #333;
        border-color: #444;
        color: #e0e0e0;
    }
    
    [data-theme="dark"] .input-group-append .btn {
        background-color: #444;
        border-color: #555;
        color: #e0e0e0;
    }
    
    [data-theme="dark"] .input-group-append .btn:hover {
        background-color: #555;
        border-color: #666;
    }
    
    [data-theme="dark"] ::placeholder {
        color: #999;
        opacity: 1;
    }

    /* Estilos para paginación en modo oscuro */
    [data-theme="dark"] .pagination .page-link {
        background-color: #333;
        border-color: #444;
        color: #e0e0e0;
    }
    
    [data-theme="dark"] .pagination .page-item.active .page-link {
        background-color: #4a90e2;
        border-color: #357abd;
    }
    
    [data-theme="dark"] .pagination .page-link:hover {
        background-color: #444;
    }
    </style>
@stop

@section('content')
<div class="row mb-3">
    <div class="col-md-6">
        <div class="input-group">
            <input type="text" class="form-control" id="searchProjects" placeholder="Buscar proyectos...">
            <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="button" id="btnSearchProjects">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </div>
</div>
    <div class="container-fluid">
        <h1>Inicio para Administradores </h1>
        <!-- Botones de acción rápida (adaptados para móvil) -->
        <div class="button-container">
<<<<<<< HEAD
            <a href="{{ route('sprints.index') }}" class="btn">Lista de Sprint</a>
=======
            <!-- <a href="{{ route('historialcambios.index') }}" class="btn">Historial</a> -->
           <!--  <a href="{{ route('reasinarhistoria.index') }}" class="btn">Reasignar</a> -->
>>>>>>> main
            <a href="{{ route('admin.users.index') }}" class="btn">Usuarios</a>
            <a href="{{ route('projects.create') }}" class="btn">Crear Proyecto</a>
        </div>
        
        <!-- Estadísticas Rápidas -->
        <div class="row mt-4">
            <div class="col-6 col-md-3">
                <div class="quick-stats">
                    <div class="stat-number">{{ \App\Models\Project::count() }}</div>
                    <div class="stat-label">Proyectos</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="quick-stats">
                    <div class="stat-number">{{ \App\Models\User::count() }}</div>
                    <div class="stat-label">Usuarios</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="quick-stats">
                    <div class="stat-number">{{ \App\Models\Sprint::where('estado', 'Nuevo')->count() }}</div>
                    <div class="stat-label">Sprints Activos</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="quick-stats">
                    <div class="stat-number">{{ \App\Models\Formatohistoria::count() }}</div>
                    <div class="stat-label">Historias</div>
                </div>
            </div>
        </div>
        
        <!-- Listado de Proyectos -->
        <div class="card admin-card">
            <div class="card-header">
                Proyectos Activos
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover admin-table">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Responsable</th>
                                <th class="d-none d-md-table-cell">Miembros</th>
                                <th class="d-none d-md-table-cell">Sprint Actual</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="projectsTableBody">
                            @foreach(\App\Models\Project::with(['creator', 'users', 'sprints' => function($query) {
                                $query->where('estado', 'activo')->orderBy('fecha_inicio', 'desc');
                            }])->get() as $proyecto)
                            <tr class="project-row">
                                <td>{{ $proyecto->name }}</td>
                                <td>{{ $proyecto->creator ? $proyecto->creator->name : 'No asignado' }}</td>
                                <td class="d-none d-md-table-cell">{{ $proyecto->users->count() }}</td>
                                <td class="d-none d-md-table-cell">
                                    @if($proyecto->sprints->count() > 0)
                                        {{ $proyecto->sprints->first()->nombre }}
                                    @else
                                        Sin sprint activo
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('tableros.show', $proyecto->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('projects.edit', $proyecto->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="pagination-container">
                        <ul class="pagination" id="projectsPagination">
                            <!-- La paginación se generará con JavaScript -->
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Actividad Reciente -->
        <div class="card admin-card mt-4">
            <div class="card-header">
                Actividad Reciente
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table admin-table" id="activityTable">
                        <thead>
                            <tr>
                                <th>Usuario</th>
                                <th>Acción</th>
                                <th class="d-none d-md-table-cell">Fecha</th>
                            </tr>
                        </thead>
                        <tbody id="activityTableBody">
                            @foreach(\App\Models\HistorialCambios::orderBy('fecha', 'desc')->get() as $cambio)
                            <tr class="activity-row">
                                <td>{{ $cambio->usuario }}</td>
                                <td>{{ $cambio->accion }}</td>
                                <td class="d-none d-md-table-cell">{{ \Carbon\Carbon::parse($cambio->fecha)->diffForHumans() }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="pagination-container">
                        <ul class="pagination" id="activityPagination">
                            <!-- La paginación se generará con JavaScript -->
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Historias de Usuario Recientes -->
        <div class="card admin-card mt-4">
            <div class="card-header">
                Historias de Usuario Recientes
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table admin-table">
                        <thead>
                            <tr>
                                <th>Título</th>
                                <th class="d-none d-md-table-cell">Tablero</th>
                                <th class="d-none d-sm-table-cell">Responsable</th>
                                <th>Prioridad</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody id="historiasTableBody">
                            @forelse(\App\Models\Formatohistoria::with(['tablero'])
                                ->orderBy('created_at', 'desc')
                                ->get() as $historia)
                                <tr class="historia-row">
                                    <td>{{ $historia->nombre }}</td>
                                    <td class="d-none d-md-table-cell">
                                        {{ $historia->tablero ? $historia->tablero->nombre : 'Sin tablero' }}
                                    </td>
                                    <td class="d-none d-sm-table-cell">
                                        {{ $historia->responsable ?: 'No asignado' }}
                                    </td>
                                    <td>
                                        @switch(strtolower($historia->prioridad))
                                            @case('alta')
                                                <span class="badge bg-danger">Alta</span>
                                                @break
                                            @case('media')
                                                <span class="badge bg-warning">Media</span>
                                                @break
                                            @case('baja')
                                                <span class="badge bg-info">Baja</span>
                                                @break
                                            @default
                                                <span class="badge bg-secondary">-</span>
                                        @endswitch
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $historia->estado === 'Pendiente' ? 'warning' : 'success' }}">
                                            {{ $historia->estado }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">No hay historias registradas</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="pagination-container">
                        <ul class="pagination" id="historiasPagination">
                            <!-- La paginación se generará con JavaScript -->
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Resumen de Sprints -->
        <div class="card admin-card mt-4">
            <div class="card-header">
                Resumen de Sprints
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach(\App\Models\Sprint::with('project')->orderBy('fecha_inicio', 'desc')->limit(3)->get() as $sprint)
                    <div class="col-12 col-md-4 mb-3">
                        <div class="card h-100">
                            <div class="card-header" style="background-color: {{ $sprint->color ?? '#f8f9fa' }}">
                                {{ $sprint->nombre }}
                            </div>
                            <div class="card-body">
                                <p><strong>Proyecto:</strong> {{ $sprint->proyecto ? $sprint->proyecto->name : 'No asignado' }}</p>
                                <p><strong>Estado:</strong> {{ ucfirst($sprint->estado) }}</p>
                                <div class="row">
                                    <div class="col-6">
                                        <p><strong>Inicio:</strong> {{ \Carbon\Carbon::parse($sprint->fecha_inicio)->format('d/m/Y') }}</p>
                                    </div>
                                    <div class="col-6">
                                        <p><strong>Fin:</strong> {{ \Carbon\Carbon::parse($sprint->fecha_fin)->format('d/m/Y') }}</p>
                                    </div>
                                </div>
                                
                                @php
                                    $totalHistorias = \App\Models\HistoriaModel::where('sprint_id', $sprint->id)->count();
                                @endphp
                                
                                <p><strong>Historias:</strong> {{ $totalHistorias }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@stop

@section('adminlte_js')
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/color.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Referencias a los elementos DOM
            const searchInput = document.getElementById('searchProjects');
            const searchButton = document.getElementById('btnSearchProjects');
            const projectRows = document.querySelectorAll('.project-row');
            
            // Función para filtrar proyectos
            function filterProjects() {
                const searchTerm = searchInput.value.toLowerCase().trim();
                
                projectRows.forEach(row => {
                    const projectName = row.querySelector('td:first-child').textContent.toLowerCase();
                    const projectManager = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                    
                    // Si el texto de búsqueda está en el nombre del proyecto o en el responsable
                    if (projectName.includes(searchTerm) || projectManager.includes(searchTerm)) {
                        row.style.display = ''; // Mostrar la fila
                    } else {
                        row.style.display = 'none'; // Ocultar la fila
                    }
                });
            }
            
            // Event listeners
            searchButton.addEventListener('click', filterProjects);
            
            // También filtrar mientras se escribe (después de un pequeño delay)
            let typingTimer;
            searchInput.addEventListener('keyup', function() {
                clearTimeout(typingTimer);
                typingTimer = setTimeout(filterProjects, 500); // Esperar 500ms después de que el usuario deje de escribir
            });
            
            // Limpiar el timer si se sigue escribiendo
            searchInput.addEventListener('keydown', function() {
                clearTimeout(typingTimer);
            });
            
            // Filtrar también al presionar Enter
            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    filterProjects();
                }
            });
        });
    </script>

    <script>
        // Función de configuración de paginación para cualquier tabla
        function setupTablePagination(tableId, rowSelector, paginationId, rowsPerPage = 5) {
            const tableBody = document.getElementById(tableId);
            const rows = tableBody.querySelectorAll(rowSelector);
            const pagination = document.getElementById(paginationId);
            
            // Calcular número de páginas
            const pageCount = Math.ceil(rows.length / rowsPerPage);
            
            // Limpiar paginación existente
            pagination.innerHTML = '';
            
            // Botón Anterior
            const prevLi = document.createElement('li');
            prevLi.classList.add('page-item');
            prevLi.innerHTML = '<a class="page-link" href="#">&laquo;</a>';
            pagination.appendChild(prevLi);
            
            // Páginas numeradas
            for (let i = 1; i <= pageCount; i++) {
                const li = document.createElement('li');
                li.classList.add('page-item');
                li.innerHTML = `<a class="page-link" href="#">${i}</a>`;
                
                if (i === 1) li.classList.add('active');
                
                li.addEventListener('click', function(e) {
                    e.preventDefault();
                    showTablePage(tableBody, rows, i, rowsPerPage);
                    
                    // Actualizar clase activa
                    const pageItems = pagination.querySelectorAll('.page-item');
                    pageItems.forEach(item => item.classList.remove('active'));
                    this.classList.add('active');
                });
                
                pagination.appendChild(li);
            }
            
            // Botón Siguiente
            const nextLi = document.createElement('li');
            nextLi.classList.add('page-item');
            nextLi.innerHTML = '<a class="page-link" href="#">&raquo;</a>';
            pagination.appendChild(nextLi);
            
            // Configurar eventos para prev/next
            prevLi.addEventListener('click', function(e) {
                e.preventDefault();
                const activeItem = pagination.querySelector('.page-item.active');
                if (activeItem && activeItem.previousElementSibling && activeItem.previousElementSibling.classList.contains('page-item')) {
                    activeItem.previousElementSibling.querySelector('.page-link').click();
                }
            });
            
            nextLi.addEventListener('click', function(e) {
                e.preventDefault();
                const activeItem = pagination.querySelector('.page-item.active');
                if (activeItem && activeItem.nextElementSibling && activeItem.nextElementSibling.classList.contains('page-item')) {
                    activeItem.nextElementSibling.querySelector('.page-link').click();
                }
            });
            
            // Mostrar primera página al inicio
            showTablePage(tableBody, rows, 1, rowsPerPage);
        }

        // Función para mostrar una página específica
        function showTablePage(tableBody, rows, page, rowsPerPage) {
            // Ocultar todas las filas
            rows.forEach(row => {
                row.style.display = 'none';
            });
            
            // Calcular rango de filas para la página actual
            const startIndex = (page - 1) * rowsPerPage;
            const endIndex = Math.min(startIndex + rowsPerPage, rows.length);
            
            // Mostrar filas de la página actual
            for (let i = startIndex; i < endIndex; i++) {
                rows[i].style.display = '';
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Configuración de paginación para la tabla de proyectos
            setupTablePagination(
                'projectsTableBody', 
                '.project-row', 
                'projectsPagination', 
                5
            );
            
            // Configuración de paginación para la tabla de historias
            setupTablePagination(
                'historiasTableBody', 
                '.historia-row', 
                'historiasPagination', 
                5
            );
            
            // Configuración específica para la tabla de actividad reciente
            setupTablePagination(
                'activityTableBody', 
                '.activity-row', 
                'activityPagination', 
                5
            );
        });
    </script>
@stop