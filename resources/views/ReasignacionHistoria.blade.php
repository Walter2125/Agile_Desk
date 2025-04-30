@extends('adminlte::page')

@section('title', 'Agile Desk')

@section('adminlte_css')
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/reasignar.css') }}">

@stop

@section('content')
    <div class="container text-center mt-5">
        <h2>Reasignar Historia</h2>
        <h5>Reasignar historia del proyecto: {{ $project->name }}</h1>

        <!-- Mostrar el mensaje de éxito si está disponible -->
        @if (session('success'))
            <div class="message">{{ session('success') }}</div>
        @endif

        <!-- Formulario de reasignación -->
        <form action="{{ url('/reasignacion-historias/reasignar') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="historiaId">Seleccionar Historia</label>
                <select name="historiaId" id="historiaId" required>
                    <option value="">Seleccione una historia</option>
                    @foreach($historias as $historia)
                        <option value="{{ $historia->id }}">
                            {{ $historia->nombre }} (Responsable: {{ $historia->responsable ?? 'No asignado' }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="nuevoResponsableId">Nuevo Responsable</label>
                <select name="nuevoResponsableId" id="nuevoResponsableId" required>
                    <option value="">Seleccione un usuario</option>
                    @foreach($usuarios as $usuario)
                        <option value="{{ $usuario->id }}">{{ $usuario->name }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn">Guardar Cambios</button>
        </form>

        <!-- Botón Cancelar -->
        <a href="{{ route('homeadmin') }}" class="btn-cancel">Cancelar</a>
    </div>
@stop

@section('adminlte_js')
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/color.js') }}"></script>
@stop