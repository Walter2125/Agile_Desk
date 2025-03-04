@extends('adminlte::page')

@section('title', 'Agile Desk')

@section('adminlte_css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('style.css') }}">
@stop

@section('content')
    <section>
        <img src="{{ asset('img/home/fondo.png') }}" alt="Fondo decorativo" id="fondo">
        <img src="{{ asset('img/home/software.png') }}" alt="Imagen de software" id="sobre">
        <img src="{{ asset('img/home/persona.png') }}" alt="Persona usando Agile Desk" id="persona">
        <h1 id="text">Agile Desk</h1>
    </section>

    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function () {
            var fondo = document.getElementById('fondo');
            var sobre = document.getElementById('sobre');
            var persona = document.getElementById('persona');
            var text = document.getElementById('text');

            window.addEventListener('scroll', function () {
                var value = window.scrollY;
                fondo.style.transform = `translateY(${value}px)`;
                sobre.style.transform = `translateX(${-value * 0.5}px)`;
                persona.style.transform = `translateY(${-value * 0.15}px)`;
                text.style.transform = `translateY(${value * 0.5}px)`;
            });
        });
    </script>

    <div class="card-group mt-4">
        <div class="card">
            <img 
                src="{{ asset('img/home/crear.png') }}" 
                class="d-block mx-auto"
                style="max-width: 80%; height: auto;"
                alt="Función de crear proyectos en Agile Desk"
            >
            <div class="card-body">
                <h4 class="card-title" style="font-size: 28px; font-family: 'Arial', sans-serif;">
                    Crea Proyectos
                </h4>
                <p class="card-text">Define Sprints automáticamente. Organiza historias y tareas. Crea columnas con estados personalizados.</p>
            </div>
        </div>
        <div class="card">
            <img 
                src="{{ asset('img/home/añadir.png') }}" 
                class="d-block mx-auto"
                style="max-width: 80%; height: auto;"
                alt="Función de editar en Agile Desk"
            >
            <div class="card-body">
                <h4 class="card-title" style="font-size: 28px; font-family: 'Arial', sans-serif;">
                    Edita con Seguridad
                </h4>
                <p class="card-text">
                    Modifica proyectos, fechas o flujos en segundos. Confirmación antes de borrar ¡Cero errores accidentales! Historial de cambios para rastrear cada ajuste.
                </p>
            </div>
        </div>
        <div class="card">
            <img 
                src="{{ asset('img/home/editar.png') }}" 
                class="d-block mx-auto"
                style="max-width: 80%; height: auto;"
                alt="Función de colaboración en Agile Desk"
            >
            <div class="card-body">
                <h4 class="card-title" style="font-size: 28px; font-family: 'Arial', sans-serif;">
                    Suma Colaboradores
                </h4>
                <p class="card-text">Invita miembros por correo y asigna roles (admin o invitado). Notificaciones en tiempo real al asignar tareas. Mención de usuarios (@nombre) en comentarios.</p>
            </div>
        </div>
    </div>

     <!-- Agregamos el nuevo botón aquí -->
     <div class="mt-4" >
        <a href="{{route('sprints.index')}}" class="btn btn-primary mt-3">Lista de Sprint</a>
    </div>

    <div id="carouselExampleFade" class="carousel slide carousel-fade mt-5">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img 
                    src="{{ asset('img/home/primera.png') }}" 
                    class="d-block mx-auto"
                    style="max-width: 100%; height: auto;"
                    alt="Interfaz principal de Agile Desk"
                >
            </div>
            <div class="carousel-item">
                <img 
                    src="{{ asset('img/home/segunda.png') }}" 
                    class="d-block mx-auto"
                    style="max-width: 100%; height: auto;"
                    alt="Tablero de tareas Agile"
                >
            </div>
            <div class="carousel-item">
                <img 
                    src="{{ asset('img/home/tercera.png') }}" 
                    class="d-block mx-auto"
                    style="max-width: 100%; height: auto;"
                    alt="Reporte de Agile Desk"
                >
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
@stop

@section('adminlte_js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('color.js') }}"></script>
@stop