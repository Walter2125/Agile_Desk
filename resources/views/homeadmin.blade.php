@extends('adminlte::page')

@section('title', 'Agile Desk')

@section('adminlte_css')
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}"> 
    <style>
        .button-container {
            display: flex;
            justify-content: flex-end; /* Alinea los botones a la derecha */
            gap: 10px; /* Espacio entre botones */
            margin-top: 20px;
            padding-right: 20px; /* Margen derecho */
        }

        .button-container .btn {
            background: linear-gradient(to right, #6fb3f2, #4a90e2); /* Azul más claro */
            border: none;
            color: white;
            padding: 8px 18px; /* Tamaño más pequeño */
            font-size: 14px; /* Texto más pequeño */
            font-weight: bold;
            border-radius: 6px;
            text-transform: uppercase;
            transition: all 0.3s ease-in-out;
            box-shadow: 1px 1px 8px rgba(0, 0, 0, 0.2);
        }

        .button-container .btn:hover {
            background: linear-gradient(to right, #4a90e2, #357abd); /* Efecto hover con un tono más fuerte */
            transform: scale(1.05);
        }
    </style>
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

            function parallaxEffect() {
                var value = window.scrollY;

                if (window.innerWidth > 768) {
                    fondo.style.transform = translateY(${value * 0.5}px);
                    sobre.style.transform = translateX(${-value * 0.3}px);
                    persona.style.transform = translateY(${-value * 0.2}px);
                    text.style.transform = translateY(${value * 0.2}px); 
                } else {
                    fondo.style.transform = translateY(${value * 0.2}px);
                    sobre.style.transform = translateX(${-value * 0.1}px);
                    persona.style.transform = translateY(${-value * 0.05}px);
                    text.style.transform = translateY(${value * 0.1}px); 
                }

                requestAnimationFrame(parallaxEffect);
            }

            requestAnimationFrame(parallaxEffect);
        });
    </script>

    <div id="contenido">
        <div class="button-container">
            <a href="{{ route('sprints.index') }}" class="btn">Lista de Sprint</a>
            <a href="{{ route('historialcambios.index') }}" class="btn">Historial de Cambios</a>
            <a href="{{ route('reasinarhistoria.index') }}" class="btn">Reasignar Historia</a>
         </div>

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
    </div>
@stop

@section('adminlte_js')
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/color.js') }}"></script>
@stop