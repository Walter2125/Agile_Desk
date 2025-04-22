@extends('adminlte::page')

@section('title', 'Agile Desk')

@section('adminlte_css')
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        .detalle-btn-container {
            display: flex;
            justify-content: flex-end; /* Alinea el botón a la derecha */
            padding-right: 20px;
            margin-top: 20px;
        }

        .detalle-btn {
            background: linear-gradient(to right, #6fb3f2, #4a90e2); /* Azul claro */
            border: none;
            color: white;
            padding: 10px 20px; /* Ajuste de tamaño */
            font-size: 14px;
            font-weight: bold;
            border-radius: 6px;
            text-transform: uppercase;
            transition: all 0.3s ease-in-out;
            box-shadow: 1px 1px 8px rgba(0, 0, 0, 0.2);
        }

        .detalle-btn:hover {
            background: linear-gradient(to right, #4a90e2, #357abd); /* Efecto hover */
            transform: scale(1.05);
        }
    </style>
@stop

@section('content')
    <section>
        <img src="{{ asset('img/notas.jpg') }}" alt="Fondo decorativo" id="notas" class="img-fluid">
        <img src="{{ asset('img/home/software.png') }}" alt="Imagen de software" id="sobre" class="img-fluid">
        <h1 id="text" class="mt-3">Agile Desk</h1>
    </section>

    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function () {
            var notas = document.getElementById('notas');
            var sobre = document.getElementById('sobre');
            var text = document.getElementById('text');

            function parallaxEffect() {
                var value = window.scrollY;
                
                if (window.innerWidth > 768) {
                    notas.style.transform = `translateY(${value}px)`;
                    sobre.style.transform = `translateX(${-value * 0.5}px)`;
                    text.style.transform = `translateY(${value * 0.5}px)`;
                } else {
                    notas.style.transform = `translateY(${value * 0.2}px)`;
                    sobre.style.transform = `translateX(${-value * 0.1}px)`;
                    text.style.transform = `translateY(${value * 0.1}px)`;
                }

                requestAnimationFrame(parallaxEffect);
            }

            requestAnimationFrame(parallaxEffect);
        });
    </script>

    <!-- Botón alineado a la derecha -->
    <div class="detalle-btn-container">
        <a href="{{ route('sprints.detalle') }}" class="btn detalle-btn">Ver Detalles de Sprint</a>
    </div>

    <div class="container-fluid text-center mt-5">
        <h1 class="mb-4">Agile Desk Para Usuarios</h1>

        <div id="carouselExampleFade" class="carousel slide carousel-fade" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="{{ asset('img/imagen1.jpg') }}" class="d-block mx-auto img-fluid rounded shadow" alt="Imagen 1">
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('img/imagen3.jpg') }}" class="d-block mx-auto img-fluid rounded shadow" alt="Imagen 3">
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

        <p class="lead mt-3">Tu tablero digital para organizar Sprints de manera eficiente y colaborativa.</p>

@stop

@section('adminlte_js')
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/color.js') }}"></script>
@stop