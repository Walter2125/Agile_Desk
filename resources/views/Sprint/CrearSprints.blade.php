@extends('adminlte::page')

@section('title', 'Crear Nuevo Sprint')

@section('adminlte_css')
    <link rel="stylesheet" href="{{ asset('css/css2.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sprints.css') }}">
    <link rel="stylesheet" href="{{ asset('css/flatpickr.min.css') }}">  
    <style>
        /* Estilos específicos para el formulario de creación */
        .create-sprint-form {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            max-width: 800px;
            margin: 0 auto;
            backdrop-filter: blur(10px);
        }

        .form-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .form-header h1 {
            color: #1E3C72;
            font-weight: 600;
            font-size: 2rem;
            margin-bottom: 10px;
        }

        .form-header p {
            color: #546E7A;
            font-size: 1rem;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #455A64;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            border-radius: 8px;
            border: 1px solid #CFD8DC;
            font-family: 'Poppins', sans-serif;
            font-size: 1rem;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        .form-control:focus {
            border-color: #2196F3;
            box-shadow: 0 0 0 3px rgba(33, 150, 243, 0.25);
            outline: none;
        }

        textarea.form-control {
            min-height: 120px;
            resize: vertical;
        }

        .form-row {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }

        .form-row .form-group {
            flex: 1 1 300px;
        }

        .color-picker-container {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 10px;
        }

        .color-option {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
            position: relative;
        }

        .color-option:hover {
            transform: scale(1.15);
            box-shadow: 0 3px 8px rgba(0,0,0,0.2);
        }

        .color-option.selected {
            transform: scale(1.15);
            box-shadow: 0 0 0 3px white, 0 0 0 5px #42A5F5;
        }

        .color-option.selected:after {
            content: "✓";
            color: white;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-shadow: 0 1px 2px rgba(0,0,0,0.5);
        }

        .btn-container {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
        }

        .btn {
            padding: 12px 30px;
            border-radius: 8px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
            border: none;
            font-size: 1rem;
        }

        .btn-primary {
            background: #1976D2;
            color: white;
        }

        .btn-primary:hover {
            background: #1565C0;
            box-shadow: 0 4px 12px rgba(25, 118, 210, 0.3);
        }

        .btn-secondary {
            background: #78909C;
            color: white;
        }

        .btn-secondary:hover {
            background: #607D8B;
            box-shadow: 0 4px 12px rgba(120, 144, 156, 0.3);
        }

        .error-message {
            color: #F44336;
            font-size: 0.85rem;
            margin-top: 5px;
        }

        /* Toggle switch for "Todo el día" */
        .switch-container {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
        }

        .switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 24px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 24px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked + .slider {
            background-color: #2196F3;
        }

        input:checked + .slider:before {
            transform: translateX(26px);
        }

        .toggle-label {
            font-weight: 500;
            color: #455A64;
        }
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
        <li class="breadcrumb__item breadcrumb__item-firstChild">
            <span class="breadcrumb__inner">
                <a href="/sprints" class="breadcrumb__title">Sprints</a>
            </span>
        </li>
        <li class="breadcrumb__item breadcrumb__item--active">
            <span class="breadcrumb__inner">
                <a href="#" class="breadcrumb__title">Crear Sprint</a>
            </span>
        </li>
    </ul>
</div>  
    <div class="sprint-dashboard">
        <div class="create-sprint-form">
            <div class="form-header">
                <h1>🚀 Crear Nuevo Sprint</h1>
                <p>Completa el formulario para añadir un nuevo sprint a tu proyecto</p>
            </div>

            <form action="{{ route('sprints.store') }}" method="POST">
                @csrf
                
                <div class="form-group">
                    <label for="nombre">Nombre del Sprint <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre" name="nombre" value="{{ old('nombre') }}" required autofocus>
                    @error('nombre')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="descripcion">Descripción</label>
                    <textarea class="form-control @error('descripcion') is-invalid @enderror" id="descripcion" name="descripcion">{{ old('descripcion') }}</textarea>
                    @error('descripcion')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="fecha_inicio">Fecha de inicio <span class="text-danger">*</span></label>
                        <input type="text" class="form-control datepicker @error('fecha_inicio') is-invalid @enderror" id="fecha_inicio" name="fecha_inicio" value="{{ old('fecha_inicio') }}" required>
                        @error('fecha_inicio')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="fecha_fin">Fecha de fin <span class="text-danger">*</span></label>
                        <input type="text" class="form-control datepicker @error('fecha_fin') is-invalid @enderror" id="fecha_fin" name="fecha_fin" value="{{ old('fecha_fin') }}" required>
                        @error('fecha_fin')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="switch-container">
                    <label class="switch" for="todo_el_dia">
                        <input type="checkbox" id="todo_el_dia" name="todo_el_dia" value="1" {{ old('todo_el_dia') ? 'checked' : '' }}>
                        <span class="slider"></span>
                    </label>
                    <span class="toggle-label">Todo el día</span>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="estado">Estado <span class="text-danger">*</span></label>
                        <select class="form-control @error('estado') is-invalid @enderror" id="estado" name="estado" required>
                            <option value="PLANEADO" {{ old('estado') == 'PLANEADO' ? 'selected' : '' }}>Planeado</option>
                            <option value="EN_CURSO" {{ old('estado') == 'EN_CURSO' ? 'selected' : '' }}>En Curso</option>
                            <option value="FINALIZADO" {{ old('estado') == 'FINALIZADO' ? 'selected' : '' }}>Finalizado</option>
                        </select>
                        @error('estado')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="tipo">Tipo</label>
                        <select class="form-control @error('tipo') is-invalid @enderror" id="tipo" name="tipo">
                            <option value="NORMAL" {{ old('tipo') == 'NORMAL' ? 'selected' : '' }}>Normal</option>
                            <option value="URGENTE" {{ old('tipo') == 'URGENTE' ? 'selected' : '' }}>Urgente</option>
                            <option value="BLOQUEADO" {{ old('tipo') == 'BLOQUEADO' ? 'selected' : '' }}>Bloqueado</option>
                        </select>
                        @error('tipo')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="project_id">Proyecto <span class="text-danger">*</span></label>
                    <select class="form-control @error('project_id') is-invalid @enderror" id="project_id" name="project_id" required>
                        <option value="">Seleccionar proyecto</option>
                        @foreach($projects as $project)
                            <option value="{{ $project->id }}" {{ old('project_id')==$project->id?'selected':'' }}>
                                {{ $project->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('project_id')<div class="error-message">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label>Color del Sprint</label>
                    <input type="hidden" name="color" id="color" value="{{ old('color', '#42A5F5') }}">
                    <div class="color-picker-container">
                        <div class="color-option selected" style="background-color: #42A5F5;" data-color="#42A5F5"></div>
                        <div class="color-option" style="background-color: #66BB6A;" data-color="#66BB6A"></div>
                        <div class="color-option" style="background-color: #FFA726;" data-color="#FFA726"></div>
                        <div class="color-option" style="background-color: #EF5350;" data-color="#EF5350"></div>
                        <div class="color-option" style="background-color: #AB47BC;" data-color="#AB47BC"></div>
                        <div class="color-option" style="background-color: #EC407A;" data-color="#EC407A"></div>
                        <div class="color-option" style="background-color: #26C6DA;" data-color="#26C6DA"></div>
                        <div class="color-option" style="background-color: #FFC107;" data-color="#FFC107"></div>
                    </div>
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
    <script src="{{ asset('js/flatpickr.js') }}"></script> 
    <script src="{{ asset('js/es.js') }}"></script> 
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Inicializar datepicker para las fechas
            flatpickr(".datepicker", {
                dateFormat: "Y-m-d",
                locale: "es",
                allowInput: true
            });

            // Selector de color
            const colorOptions = document.querySelectorAll('.color-option');
            const colorInput = document.getElementById('color');

            colorOptions.forEach(option => {
                option.addEventListener('click', function() {
                    // Quitar la clase selected de todos los colores
                    colorOptions.forEach(opt => opt.classList.remove('selected'));
                    
                    // Agregar la clase selected al color seleccionado
                    this.classList.add('selected');
                    
                    // Actualizar el valor del input oculto
                    colorInput.value = this.dataset.color;
                });
            });

            // Seleccionar el color guardado en el formulario (para cuando hay errores de validación)
            const savedColor = colorInput.value;
            if (savedColor) {
                const savedOption = document.querySelector(`.color-option[data-color="${savedColor}"]`);
                if (savedOption) {
                    colorOptions.forEach(opt => opt.classList.remove('selected'));
                    savedOption.classList.add('selected');
                }
            }
        });
    </script>
    <script src="{{ asset('js/color.js') }}"></script>
@stop