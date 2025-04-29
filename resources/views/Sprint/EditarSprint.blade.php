@extends('adminlte::page')

@section('title', 'Editar Sprint')

@section('adminlte_css')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/flatpickr.min.css') }}">
    <style>
        /* Centrar el contenido */
        .content-wrapper {
            margin-left: 0 !important;
            min-height: 100vh !important;
        }

        .content {
            margin: 0 auto;
            padding: 20px;
            width: 100%;
            max-width: 800px;
        }

        /* Estilo del formulario */
        .edit-sprint-form {
            background-color: #ffffff;
            border: 2px solid #ccc;
            border-radius: 10px;
            padding: 30px 40px;
            margin: 20px auto;
            box-sizing: border-box;
            width: 100%;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        }

        /* Modo oscuro */
        [data-theme="dark"] body {
            background-color: #121212;
        }

        [data-theme="dark"] .content {
            background-color: #121212;
        }

        [data-theme="dark"] .edit-sprint-form {
            background-color: #1e1e1e;
            color: #f0f0f0;
        }

        /* Estilo de los encabezados */
        .form-header {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .form-header h1 {
            font-size: 1.75rem;
            margin: 0;
        }

        /* Estilo de los campos del formulario */
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

        /* Estilo de las filas del formulario */
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

        /* Botones */
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
        <div class="edit-sprint-form">
            <div class="form-header">
                <h1>🔄 Editar Sprint</h1>
            </div>

            <form action="{{ route('sprints.update', $sprint->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="nombre">Nombre del Sprint <span class="text-danger">*</span></label>
                    <input type="text"
                           id="nombre"
                           name="nombre"
                           class="form-control @error('nombre') is-invalid @enderror"
                           value="{{ old('nombre', $sprint->nombre) }}"
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
                               value="{{ old('fecha_inicio', $sprint->fecha_inicio->format('Y-m-d')) }}"
                               required>
                        @error('fecha_inicio')<div class="error-message">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label for="fecha_fin">Fecha de fin <span class="text-danger">*</span></label>
                        <input type="text"
                               id="fecha_fin"
                               name="fecha_fin"
                               class="form-control datepicker @error('fecha_fin') is-invalid @enderror"
                               value="{{ old('fecha_fin', $sprint->fecha_fin->format('Y-m-d')) }}"
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
                                    {{ old('project_id', $sprint->project_id) == $project->id ? 'selected' : '' }}>
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
                           value="{{ old('color', $sprint->color) }}">
                </div>

                <div class="form-check mb-3">
                    <input type="checkbox"
                           id="todo_el_dia"
                           name="todo_el_dia"
                           class="form-check-input"
                           value="1"
                           {{ old('todo_el_dia', $sprint->todo_el_dia) ? 'checked' : '' }}>
                    <label class="form-check-label" for="todo_el_dia">Todo el día</label>
                </div>

                <div class="btn-container">
                    <a href="{{ route('sprints.index') }}" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Actualizar Sprint</button>
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