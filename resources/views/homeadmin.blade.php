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

    <div id="contenido">
        <div class="mt-4 text-center">
            <a href="{{route('sprints.index')}}" class="btn btn-primary mt-2" id="boton">Lista de Sprint</a>
        </div>

        <div id="contenido">
    <div class="mt-4 text-center">
        <!-- Enlace que se ve como un botón -->
        <a href="{{ route('historial.cambios') }}" class="btn btn-primary mt-2" id="boton">Historial de Cambios</a>
    </div>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('color.js') }}"></script>
@stop