@extends('adminlte::page')

@section('title', 'Panel de Administración - Agile Desk')

@section('adminlte_css')
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}"> 
    <style>
        /* Estilos originales para parallax */
        section {
            position: relative;
            height: 300px;
            overflow: hidden;
            margin-bottom: 30px;
        }
        
        #fondo, #sobre, #persona {
            position: absolute;
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
            justify-content: flex-end;
            gap: 10px;
            margin-top: 20px;
            padding-right: 20px;
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
        
        .admin-table th {
            background-color: #f8f9fa;
        }
        
        /* Estilos para el carrusel */
        .carousel-item img {
            max-height: 400px;
            object-fit: contain;
        }
    </style>
@stop

@section('content')
    <!-- Sección Parallax -->
    <section>
        <img src="{{ asset('img/home/fondo.png') }}" alt="Fondo decorativo" id="fondo">
        <img src="{{ asset('img/home/software.png') }}" alt="Imagen de software" id="sobre">
        <img src="{{ asset('img/home/persona.png') }}" alt="Persona usando Agile Desk" id="persona">
        <h1 id="text">Agile Desk Admin</h1>
    </section>

    <!-- Script para el efecto parallax -->
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function () {
            var fondo = document.getElementById('fondo');
            var sobre = document.getElementById('sobre');
            var persona = document.getElementById('persona');
            var text = document.getElementById('text');

            function parallaxEffect() {
                var value = window.scrollY;

                if (window.innerWidth > 768) {
                    fondo.style.transform = `translateY(${value * 0.5}px)`;
                    sobre.style.transform = `translateX(${-value * 0.3}px)`;
                    persona.style.transform = `translateY(${-value * 0.2}px)`;
                    text.style.transform = `translateY(${value * 0.2}px)`; 
                } else {
                    fondo.style.transform = `translateY(${value * 0.2}px)`;
                    sobre.style.transform = `translateX(${-value * 0.1}px)`;
                    persona.style.transform = `translateY(${-value * 0.05}px)`;
                    text.style.transform = `translateY(${value * 0.1}px)`; 
                }

                requestAnimationFrame(parallaxEffect);
            }

            requestAnimationFrame(parallaxEffect);
        });
    </script>

    <div class="container-fluid">
        <!-- Botones de acción rápida (manteniendo tu estilo original) -->
        <div class="button-container">
            <a href="{{ route('sprints.index') }}" class="btn">Lista de Sprint</a>
            <a href="{{ route('historialcambios.index') }}" class="btn">Historial de Cambios</a>
            <a href="{{ route('reasinarhistoria.index') }}" class="btn">Reasignar Historia</a>
            <a href="{{ route('admin.users.index') }}" class="btn">Gestionar Usuarios</a>
            <a href="{{ route('projects.create') }}" class="btn">Crear Proyecto</a>
        </div>
        
        <!-- Estadísticas Rápidas -->
        <div class="row mt-4">
            <div class="col-md-3 col-sm-6">
                <div class="quick-stats">
                    <div class="stat-number">5</div>
                    <div class="stat-label">Proyectos</div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="quick-stats">
                    <div class="stat-number">12</div>
                    <div class="stat-label">Usuarios</div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="quick-stats">
                    <div class="stat-number">8</div>
                    <div class="stat-label">Sprints Activos</div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="quick-stats">
                    <div class="stat-number">45</div>
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
                                <th>Miembros</th>
                                <th>Sprint Actual</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Proyecto A</td>
                                <td>Juan Pérez</td>
                                <td>5</td>
                                <td>Sprint 3</td>
                                <td>
                                    <a href="{{ route('tableros.show', 1) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('projects.edit', 1) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>Proyecto B</td>
                                <td>María López</td>
                                <td>3</td>
                                <td>Sprint 2</td>
                                <td>
                                    <a href="{{ route('tableros.show', 2) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('projects.edit', 2) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <!-- Carrusel (mantenido de tu diseño original) -->
        <div id="carouselExampleFade" class="carousel slide carousel-fade mt-3">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div class="container">
                        <img 
                            src="{{ asset('img/home/primera.png') }}" 
                            class="d-block mx-auto img-fluid"
                            alt="Interfaz principal de Agile Desk"
                        >
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="container">
                        <img 
                            src="{{ asset('img/home/segunda.png') }}" 
                            class="d-block mx-auto img-fluid"
                            alt="Tablero de tareas Agile"
                        >
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="container">
                        <img 
                            src="{{ asset('img/home/tercera.png') }}" 
                            class="d-block mx-auto img-fluid"
                            alt="Reporte de Agile Desk"
                        >
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
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
                                <th>Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Juan Pérez</td>
                                <td>Actualizó el estado de la historia "Inicio de sesión"</td>
                                <td>Hace 2 horas</td>
                            </tr>
                            <tr>
                                <td>María López</td>
                                <td>Creó un nuevo sprint "Sprint 3"</td>
                                <td>Hace 5 horas</td>
                            </tr>
                            <tr>
                                <td>Carlos Ruiz</td>
                                <td>Se unió al proyecto "Proyecto B"</td>
                                <td>Hace 1 día</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop

@section('adminlte_js')
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/color.js') }}"></script>
@stop