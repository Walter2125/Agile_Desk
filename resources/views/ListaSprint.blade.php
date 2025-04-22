@extends('adminlte::page')

@section('title', 'Sprints - Agile Desk')

@section('adminlte_css')
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/sprints.css') }}">
@stop

@section('content')
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
                    <label for="status-filter">Estado:</label>
                    <select id="status-filter" class="filter-select">
                        <option value="all">Todos</option>
                        <option value="PLANEADO">Planeado</option>
                        <option value="EN_CURSO">En curso</option>
                        <option value="FINALIZADO">Finalizado</option>
                    </select>
                </div>
                
                @if(isset($proyectoId))
                <div class="filter-group">
                    <label for="project-filter">Proyecto:</label>
                    <select id="project-filter" class="filter-select">
                        <option value="all">Todos los proyectos</option>
                        @foreach($proyectos as $proyecto)
                            <option value="{{ $proyecto->id }}" {{ $proyectoId == $proyecto->id ? 'selected' : '' }}>
                                {{ $proyecto->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @endif
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
                <a href="{{ route('tableros.show', $sprint->id) }}" class="sprint-card" 
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
                            
                            // Convert status labels
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
                            
                            // Use sprint color if available
                            $borderColor = $sprint->color ?? '#42A5F5';
                        @endphp
                        
                        <div class="sprint-status status-{{ $statusClass }}">
                            <span class="status-indicator"></span>{{ $statusText }}
                        </div>
                    </div>
                    
                    <div class="card-overlay">
                        <span class="view-details">Ver tablero</span>
                    </div>
                </a>
            @empty
                <div class="no-sprints">
                    <p>No hay sprints disponibles actualmente.</p>
                    <a href="{{ route('sprints.create') }}" class="create-button">Crear primer sprint</a>
                </div>
            @endforelse
        </div>
        
        <div id="loading-indicator" class="loading-spinner hidden">
            <div class="spinner"></div>
            <span>Cargando...</span>
        </div>
    </div>
@stop

@section('adminlte_js')
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        // Cache DOM elements
        const sprintList = document.getElementById('sprint-list');
        const sortSelect = document.getElementById('sort');
        const statusFilter = document.getElementById('status-filter');
        const projectFilter = document.getElementById('project-filter');
        const loadingIndicator = document.getElementById('loading-indicator');
        
        // Filter and sort sprints function
        function filterAndSortSprints() {
            showLoading();
            
            setTimeout(() => {
                const createCard = document.querySelector('.create-card');
                const sprints = Array.from(sprintList.querySelectorAll('.sprint-card:not(.create-card):not(.no-sprints)'));
                const sortBy = sortSelect.value;
                const statusValue = statusFilter.value;
                const projectValue = projectFilter ? projectFilter.value : 'all';
                
                // Sort the sprints
                sprints.sort((a, b) => {
                    const dateA = new Date(a.dataset[sortBy]);
                    const dateB = new Date(b.dataset[sortBy]);
                    return dateA - dateB;
                });
                
                // Clear and rebuild the list, keeping the create card at the top
                sprintList.innerHTML = "";
                
                // Add create card back first
                if (createCard) {
                    sprintList.appendChild(createCard);
                }
                
                // Filter and add sprints
                let visibleCount = 0;
                
                sprints.forEach(sprint => {
                    const matchesStatus = statusValue === 'all' || sprint.dataset.status === statusValue;
                    const matchesProject = projectValue === 'all' || sprint.dataset.proyecto === projectValue;
                    
                    if (matchesStatus && matchesProject) {
                        sprintList.appendChild(sprint);
                        visibleCount++;
                    }
                });
                
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
                        if (projectFilter) projectFilter.value = 'all';
                        filterAndSortSprints();
                    });
                }
                
                hideLoading();
            }, 300); // Small delay to allow UI to show loading state
        }
        
        // Show/hide loading indicator
        function showLoading() {
            loadingIndicator.classList.remove('hidden');
        }
        
        function hideLoading() {
            loadingIndicator.classList.add('hidden');
        }
        
        // Event listeners
        if (sortSelect) sortSelect.addEventListener('change', filterAndSortSprints);
        if (statusFilter) statusFilter.addEventListener('change', filterAndSortSprints);
        if (projectFilter) projectFilter.addEventListener('change', filterAndSortSprints);
        
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