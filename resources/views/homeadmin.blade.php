@extends('adminlte::page')

@section('title', 'Panel de Administración - Agile Desk')

@section('adminlte_css')
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}"> 
    <style>
        /* Estilos responsivos para parallax */
        section.parallax-container {
            position: relative;
            height: 300px;
            overflow: hidden;
            margin-bottom: 30px;
        }
        
        .parallax-layer {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
        }
        
        #fondo, #sobre, #persona{
            position: absolute;
            width: 100%;
            height: auto;
            max-width: 100%;
            object-fit: contain;
        }
        
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
        
        /* Ajustes responsivos para móviles */
        @media (max-width: 768px) {
            section.parallax-container {
                height: 200px;
            }
            
            #text {
                font-size: 2rem;
            }
            
            #sobre {
                max-width: 70%;
                right: -5%;
            }
            
            #persona {
                max-height: 80%;
                left: 0;
            }
        }
        
        @media (max-width: 576px) {
            section.parallax-container {
                height: 150px;
            }
            
            #text {
                font-size: 1.5rem;
            }
            
            #sobre {
                max-width: 70%;
                right: -10%;
            }
            
            #persona {
                max-height: 70%;
                left: -5%;
            }
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

    </style>
@stop

@section('content')
    <!-- Sección Parallax Responsiva -->
    <section class="parallax-container">
        <img src="{{ asset('img/home/fondo.png') }}" alt="Fondo decorativo" id="fondo" class="parallax-layer">
        <img src="{{ asset('img/home/software.png') }}" alt="Imagen de software" id="sobre" class="parallax-layer">
        <img src="{{ asset('img/home/persona.png') }}" alt="Persona usando Agile Desk" id="persona" class="parallax-layer">
        <h1 id="text">Agile Desk Admin</h1>
    </section>

    <!-- Script para el efecto parallax optimizado para móviles -->
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function () {
            var fondo = document.getElementById('fondo');
            var sobre = document.getElementById('sobre');
            var persona = document.getElementById('persona');
            var text = document.getElementById('text');
            var lastScrollTop = 0;
            
            // Detectar si es dispositivo móvil
            var isMobile = window.innerWidth <= 768;
            
            // Configurar factores de parallax según el dispositivo
            var factors = {
                fondo: isMobile ? 0.15 : 0.5,
                sobre: isMobile ? 0.1 : 0.3,
                persona: isMobile ? 0.05 : 0.2,
                text: isMobile ? 0.1 : 0.2
            };
            
            // Función para ajustar los factores cuando cambia el tamaño de la ventana
            window.addEventListener('resize', function() {
                isMobile = window.innerWidth <= 768;
                factors = {
                    fondo: isMobile ? 0.15 : 0.5,
                    sobre: isMobile ? 0.1 : 0.3,
                    persona: isMobile ? 0.05 : 0.2,
                    text: isMobile ? 0.1 : 0.2
                };
            });

            function parallaxEffect() {
                var scrollTop = window.scrollY || document.documentElement.scrollTop;
                
                // Limitar el efecto parallax a cierta distancia de scroll
                var maxEffectScroll = 500;
                var effectiveScroll = Math.min(scrollTop, maxEffectScroll);
                
                // Optimizar para rendimiento en móviles
                if (isMobile && Math.abs(scrollTop - lastScrollTop) < 5) {
                    requestAnimationFrame(parallaxEffect);
                    return; // Reduce cálculos en scrolls pequeños en móviles
                }
                
                lastScrollTop = scrollTop;
                
                // Aplicar transformaciones con los factores adecuados
                fondo.style.transform = `translateY(${effectiveScroll * factors.fondo}px)`;
                sobre.style.transform = `translateX(${-effectiveScroll * factors.sobre}px)`;
                persona.style.transform = `translateY(${-effectiveScroll * factors.persona}px)`;
                text.style.transform = `translate(-50%, ${-50% + (effectiveScroll * factors.text)}px)`;
                
                requestAnimationFrame(parallaxEffect);
            }

            // Iniciar animación solo si está visible en el viewport
            var observer = new IntersectionObserver((entries) => {
                if (entries[0].isIntersecting) {
                    requestAnimationFrame(parallaxEffect);
                }
            }, { threshold: 0.1 });
            
            observer.observe(document.querySelector('.parallax-container'));
        });
    </script>

    <div class="container-fluid">
        <!-- Botones de acción rápida (adaptados para móvil) -->
        <div class="button-container">
            <a href="{{ route('sprints.index') }}" class="btn">Lista de Sprint</a>
            <a href="{{ route('historialcambios.index') }}" class="btn">Historial</a>
         <!-- <a href="{{ route('reasinarhistoria.index') }}" class="btn">Reasignar</a>--> 
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
                    <div class="stat-number">{{ \App\Models\HistoriaModel::count() }}</div>
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
                        <tbody>
                            @foreach(\App\Models\Project::with(['creator', 'users', 'sprints' => function($query) {
                                $query->where('estado', 'activo')->orderBy('fecha_inicio', 'desc');
                            }])->get() as $proyecto)
                            <tr>
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
                    <table class="table admin-table">
                        <thead>
                            <tr>
                                <th>Usuario</th>
                                <th>Acción</th>
                                <th class="d-none d-md-table-cell">Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(\App\Models\HistorialCambios::orderBy('fecha', 'desc')->limit(10)->get() as $cambio)
                            <tr>
                                <td>{{ $cambio->usuario }}</td>
                                <td>{{ $cambio->accion }}</td>
                                <td class="d-none d-md-table-cell">{{ \Carbon\Carbon::parse($cambio->fecha)->diffForHumans() }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
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
                                <th class="d-none d-md-table-cell">Sprint</th>
                                <th class="d-none d-sm-table-cell">Responsable</th>
                                <th>Prioridad</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(\App\Models\HistoriaModel::with('sprint')->orderBy('created_at', 'desc')->limit(5)->get() as $historia)
                            <tr>
                                <td>{{ $historia->titulo }}</td>
                                <td class="d-none d-md-table-cell">{{ $historia->sprint ? $historia->sprint->nombre : 'No asignado' }}</td>
                                <td class="d-none d-sm-table-cell">{{ $historia->responsable ?: 'No asignado' }}</td>
                                <td>
                                    @switch($historia->prioridad)
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
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
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
@stop