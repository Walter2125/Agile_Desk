@extends('adminlte::page')

@section('title', 'Sprints - Agile Desk')

@section('adminlte_css')
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/sprints.css') }}">
    <style>
.migajas {
  margin: 1rem 0;
  padding: 0 1rem;
  /* ¡QUITAR height y min-width! */
  /* height: 100%; */
  /* min-width: 480px; */
  overflow: visible;                 /* Asegura que no se corten los skew */
}

/* --- Listado de migajas --- */
.migajas .breadcrumb {
    background-color: linear-gradient(120deg, #1E3C72, #2A5298);
  display: flex;
  flex-wrap: wrap;
  list-style: none;
  margin: 0;
  padding: 0;
  /* Quitar translateY */
  /* transform: translateY(-50%); */
  position: relative;
  z-index: 2;
}

/* Ítems de migajas */
.migajas .breadcrumb__item {
  display: inline-flex;
  align-items: center;
  background-color: #fff !important;  /* Asegura el fondo blanco */
  color: #252525;
  font-family: 'Oswald', sans-serif;
  font-size: 0.9rem;
  text-transform: uppercase;
  padding: 0.5rem 1rem;
  margin-right: 0.5rem;
  border-radius: 7px;
  box-shadow: 0 2px 5px rgba(0,0,0,0.2);
  
}

.migajas .breadcrumb__item:hover {
  background-color: #490099;
  color: #fff;
}

/* Contenido interior para “des-skewear” */
.migajas .breadcrumb__inner {
  transform: skew(21deg);
}

/* Ítem activo */
.migajas .breadcrumb__item--active {
  background-color: #8e00d4 !important;
  color: #fff !important;
  pointer-events: none;
}

    </style>
@stop

@section('content')
<!-- migajas de pan-->
<div class="container py-3 migajas" id="migajas">
    <ul class="breadcrumb">
        <li class="breadcrumb__item breadcrumb__item-firstChild">
            <span class="breadcrumb__inner">
                <a href="/dashboard" class="breadcrumb__title">Home</a>
            </span>
        </li>
        <li class="breadcrumb__item breadcrumb__item-firstChild">
            <span class="breadcrumb__inner">
                <a href="/projects" class="breadcrumb__title">Proyectos</a>
            </span>
        </li>
        <li class="breadcrumb__item breadcrumb__item--active">
            <span class="breadcrumb__inner">
                <a href="#" class="breadcrumb__title">Sprints</a>
            </span>
        </li>
    </ul>
</div>  
    <div class="sprint-dashboard">
        <header class="dashboard-header">
            <h1>📋 Sprints</h1>
            
            <div class="filter-controls">
                <div class="filter-group">
                    <label for="sort">Ordenar por:</label>
                    <select id="sort" class="filter-select">
                        <option value="fecha_inicio">Fecha de inicio</option>
                        <option value="fecha_fin">Fecha de fin</option>
                    </select>
                </div>
                
                <div class="filter-group">
                    <label for="project-filter">Proyecto:</label>
                    <select id="project-filter" class="filter-select">
                        <option value="all">Todos los proyectos</option>
                        @foreach($proyectos as $proyecto)
                            <option value="{{ $proyecto->id }}" {{ isset($proyectoId) && $proyectoId == $proyecto->id ? 'selected' : '' }}>
                                {{ $proyecto->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
            </div>
        </header>

        <div id="sprint-list" class="sprint-grid" role="list">
            <!-- Create New Sprint Card -->
            <a href="{{ route('sprints.create') }}" class="sprint-card create-card" aria-label="Crear nuevo sprint">
                <div class="create-content">
                    <div class="create-icon">+</div>
                    <h2 class="create-title">Crear Nuevo Sprint</h2>
                    <p class="create-desc">Añadir un nuevo sprint al proyecto</p>
                </div>
            </a>
            
            @forelse($sprints as $sprint)
                    <div class="sprint-card position-relative" 
                        data-start="{{ $sprint->fecha_inicio }}" 
                        data-end="{{ $sprint->fecha_fin }}" 
                        data-id="{{ $sprint->id }}"
                        data-status="{{ $sprint->estado }}"
                        data-proyecto="{{ $sprint->proyecto_id }}"
                        role="listitem"
                        aria-label="Sprint {{ $sprint->nombre }}">

                        <h2 class="sprint-title">{{ $sprint->nombre }}</h2>

                        @if($sprint->descripcion)
                            <p class="sprint-description">{{ \Illuminate\Support\Str::limit($sprint->descripcion, 60) }}</p>
                        @endif

                        <div class="sprint-details">
                            <p class="sprint-date">
                                <span class="icon">📅</span> Inicio: 
                                <time datetime="{{ $sprint->fecha_inicio }}">{{ $sprint->fecha_inicio->format('d/m/Y') }}</time>
                            </p>
                            
                            <p class="sprint-date">
                                <span class="icon">⏳</span> Fin: 
                                <time datetime="{{ $sprint->fecha_fin }}">{{ $sprint->fecha_fin->format('d/m/Y') }}</time>
                            </p>

                            @if($sprint->project)
                                <p class="sprint-project">
                                    <span class="icon">🏢</span> Proyecto:
                                    <span>{{ $sprint->project->name }}</span>
                                </p>
                            @endif

                            @php
                                $statusClass = str_replace(' ', '_', strtolower($sprint->estado));
                                $statusText = ucfirst(strtolower($sprint->estado));

                                if ($statusClass == 'en_curso') {
                                    $statusClass = 'active';
                                    $statusText = 'En curso';
                                } elseif ($statusClass == 'planeado') {
                                    $statusClass = 'planned';
                                    $statusText = 'Planeado';
                                } elseif ($statusClass == 'finalizado') {
                                    $statusClass = 'completed';
                                    $statusText = 'Finalizado';
                                }
                            @endphp

                            <div class="sprint-status status-{{ $statusClass }}">
                                <span class="status-indicator"></span>{{ $statusText }}
                            </div>
                        </div>

                        <!-- 🔽 Botones DENTRO del card, todos válidos -->
                        <div class="card-overlay d-flex flex-column align-items-center">
                            <a href="{{ route('projects.tablero', $sprint->id) }}" class="view-details mb-2">Ver tablero</a>
                            <a href="{{ route('sprints.edit', $sprint->id) }}" class="view-details mb-2">Editar</a>
                            
                            <!-- Formulario válido, no está dentro de <a> -->
                            <form action="{{ route('sprints.destroy', $sprint->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="view-details">Borrar</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="no-sprints">
                        <p>No hay sprints disponibles actualmente.</p>
                        <a href="{{ route('sprints.create') }}" class="create-button">Crear primer sprint</a>
                    </div>
            @endforelse

        </div>
    
    </div>
@stop

@section('adminlte_js')
<script src="{{ asset('js/color.js') }}"></script>
<script>
        document.addEventListener("DOMContentLoaded", function() {
        // Cache DOM elements
        const sprintList = document.getElementById('sprint-list');
        const sortSelect = document.getElementById('sort');
        const statusFilter = document.getElementById('status-filter');
        const projectFilter = document.getElementById('project-filter');
        // Event handler for project filter changes
        if (projectFilter) {
            projectFilter.addEventListener('change', function() {
                const projectId = this.value;
                // Redirect to same page with project filter applied
                window.location.href = `${window.location.pathname}?proyecto_id=${projectId}`;
            });
        }
        
        // Filter and sort sprints function
        function filterAndSortSprints() {
            showLoading();
            
            setTimeout(() => {
                const createCard = document.querySelector('.create-card');
                const sprints = Array.from(sprintList.querySelectorAll('.sprint-card:not(.create-card):not(.no-sprints)'));
                const sortBy = sortSelect.value;
                const statusValue = statusFilter.value;
                
                // Group sprints by project
                const sprintsByProject = {};
                
                sprints.forEach(sprint => {
                    const projectId = sprint.dataset.proyecto;
                    if (!sprintsByProject[projectId]) {
                        sprintsByProject[projectId] = [];
                    }
                    sprintsByProject[projectId].push(sprint);
                });
                
                // Sort each project's sprints
                for (const projectId in sprintsByProject) {
                    sprintsByProject[projectId].sort((a, b) => {
                        const dateA = new Date(a.dataset[sortBy]);
                        const dateB = new Date(b.dataset[sortBy]);
                        return dateA - dateB;
                    });
                }
                
                // Clear and rebuild the list, keeping the create card at the top
                sprintList.innerHTML = "";
                
                // Add create card back first
                if (createCard) {
                    sprintList.appendChild(createCard);
                }
                
                // Filter and add sprints grouped by project
                let visibleCount = 0;
                
                // For each project, add its sprints
                for (const projectId in sprintsByProject) {
                    let projectSprintsVisible = 0;
                    
                    // For each sprint in this project
                    sprintsByProject[projectId].forEach(sprint => {
                        const matchesStatus = statusValue === 'all' || sprint.dataset.status === statusValue;
                        
                        if (matchesStatus) {
                            // If this is the first visible sprint for this project, add a project header
                            if (projectSprintsVisible === 0) {
                                const projectName = sprint.querySelector('.sprint-project span').textContent;
                                const projectHeader = document.createElement('div');
                                projectHeader.className = 'project-header';
                                projectHeader.innerHTML = `<h3>Proyecto: ${projectName}</h3>`;
                                sprintList.appendChild(projectHeader);
                            }
                            
                            sprintList.appendChild(sprint);
                            visibleCount++;
                            projectSprintsVisible++;
                        }
                    });
                }
                
                // Show "no sprints" message if all are filtered out
                if (visibleCount === 0) {
                    const noResults = document.createElement('div');
                    noResults.className = 'no-sprints';
                    noResults.innerHTML = `
                        <p>No hay sprints que coincidan con los filtros seleccionados.</p>
                        <button class="reset-filters-button">Restablecer filtros</button>
                    `;
                    sprintList.appendChild(noResults);
                    
                    // Add event listener to the reset button
                    noResults.querySelector('.reset-filters-button').addEventListener('click', function() {
                        statusFilter.value = 'all';
                        window.location.href = window.location.pathname;
                    });
                }
                
                hideLoading();
            }, 300); // Small delay to allow UI to show loading state
        }
        
        // Event listeners
        if (sortSelect) sortSelect.addEventListener('change', filterAndSortSprints);
        if (statusFilter) statusFilter.addEventListener('change', filterAndSortSprints);
        
        // Initialize custom border colors for sprint cards
        document.querySelectorAll('.sprint-card:not(.create-card)').forEach(card => {
            const borderColor = card.getAttribute('data-color');
            if (borderColor) {
                card.style.borderLeftColor = borderColor;
            }
        });
        
       
    });
    
</script>
@stop