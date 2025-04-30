@extends('adminlte::page')

@section('title', 'Crear Nuevo Sprint')

@section('adminlte_css')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/flatpickr.min.css') }}">
    <style>
        html, body, .wrapper, .content-wrapper {
            height: 100% !important;
            margin: 0;
            padding: 0;
            overflow-x: hidden; /* quita scroll horizontal */
            overflow-y: hidden;  <- descomenta si quieres quitar vertical */
        }

        /* La cabecera ocupa espacio; restamos su altura para centrar en el resto */
        .content {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: calc(100vh - 56px); /* Ajusta 56px si tu header tiene otra altura */
            padding: 0 15px;
        }

        /* 2) Tu formulario: ancho controlado, sin sombras enormes */
        .create-sprint-form {
            background-color: #ffffff;
            border: 2px solid #ccc;
            border-radius: 10px;
            padding: 30px 40px;
            margin: 20px auto;
            box-sizing: border-box;
            width: 100%;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);

        }

        /* 3) Modo oscuro: fondo de toda la zona y del formulario */
        [data-theme="dark"] body {
            background-color: #121212;
        }
        [data-theme="dark"] .content {
            background-color: #121212;
        }
        [data-theme="dark"] .create-sprint-form {
            background-color: #1e1e1e;
            color: #f0f0f0;
        }

        /* 4) Espaciados y estilos de formulario */
        .form-header {
            text-align: center;
            margin-bottom: 1.5rem;
        }
        .form-header h1 {
            font-size: 1.75rem;
            margin: 0;
        }
        .form-group {
            margin-bottom: 1rem;
        }
        .form-group label {
            display: block;
            margin-bottom: .25rem;
            font-weight: 500;
        }
        .form-control, .form-select, .form-check-input {
            width: 100%;
            padding: .5rem .75rem;
            border-radius: 4px;
            border: 1px solid #CFD8DC;
            transition: border-color .2s;
        }
        [data-theme="dark"] .form-control,
        [data-theme="dark"] .form-select {
            background-color: #2b2b2b;
            border-color: #444;
            color: #fff;
        }
        [data-theme="dark"] .form-check-input {
            background-color: #2b2b2b;
        }
        .form-row {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
        }
        .form-row .form-group {
            flex: 1 1 100%;
        }
        @media (min-width: 576px) {
            .form-row .form-group {
                flex: 1 1 calc(50% - .5rem);
            }
        }
        .btn-container {
            display: flex;
            flex-direction: column;
            gap: .75rem;
            margin-top: 1.25rem;
        }
        @media (min-width: 576px) {
            .btn-container {
                flex-direction: row;
                justify-content: space-between;
            }
        }
        .btn {
            padding: .5rem 1.25rem;
        }
        .error-message {
            color: #dc3545;
            font-size: .875rem;
            margin-top: .25rem;
        }
    </style>
@stop

@section('content')
    <div class="content">
        <div class="create-sprint-form">
            <div class="form-header">
                <h1>🚀 Crear Nuevo Sprint</h1>
            </div>

            <form action="{{ route('sprints.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="nombre">Nombre del Sprint <span class="text-danger">*</span></label>
                    <input type="text"
                           id="nombre"
                           name="nombre"
                           class="form-control @error('nombre') is-invalid @enderror"
                           value="{{ old('nombre') }}"
                           required>
                    @error('nombre')<div class="error-message">{{ $message }}</div>@enderror
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="fecha_inicio">Fecha de inicio <span class="text-danger">*</span></label>
                        <input type="text"
                               id="fecha_inicio"
                               name="fecha_inicio"
                               class="form-control datepicker @error('fecha_inicio') is-invalid @enderror"
                               value="{{ old('fecha_inicio') }}"
                               required>
                        @error('fecha_inicio')<div class="error-message">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label for="fecha_fin">Fecha de fin <span class="text-danger">*</span></label>
                        <input type="text"
                               id="fecha_fin"
                               name="fecha_fin"
                               class="form-control datepicker @error('fecha_fin') is-invalid @enderror"
                               value="{{ old('fecha_fin') }}"
                               required>
                        @error('fecha_fin')<div class="error-message">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="project_id">Proyecto <span class="text-danger">*</span></label>
                    <select id="project_id"
                            name="project_id"
                            class="form-select @error('project_id') is-invalid @enderror"
                            required>
                        <option value="">Seleccionar proyecto</option>
                        @foreach($projects as $project)
                            <option value="{{ $project->id }}"
                                    {{ old('project_id') == $project->id ? 'selected' : '' }}>
                                {{ $project->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('project_id')<div class="error-message">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label for="color">Color del Sprint</label>
                    <input type="color"
                           id="color"
                           name="color"
                           class="form-control"
                           value="{{ old('color', '#42A5F5') }}">
                </div>

                <div class="form-check mb-3">
                    <input type="checkbox"
                           id="todo_el_dia"
                           name="todo_el_dia"
                           class="form-check-input"
                           value="1"
                           {{ old('todo_el_dia') ? 'checked' : '' }}>
                    <label class="form-check-label" for="todo_el_dia">Todo el día</label>
                </div>

                <div class="btn-container">
                    <a href="{{ route('sprints.index') }}" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Crear Sprint</button>
                </div>
            </form>
        </div>
    </div>
@stop

@section('adminlte_js')
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/color.js') }}"></script>
    <script src="{{ asset('js/flatpickr.js') }}"></script>
    <script src="{{ asset('js/es.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            flatpickr(".datepicker", {
                dateFormat: "Y-m-d",
                locale: "es",
                allowInput: true
            });
        });
    </script>
@stop
