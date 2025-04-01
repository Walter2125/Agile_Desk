@extends('adminlte::page')
@section('title', 'Agile Desk')
@section("adminlte_css")

@section('content')

<h2>Editar Tarea</h2>

<form action="{{ route('tareas.update', $tarea->id) }}" method="POST">
    @csrf
    @method('PATCH')

    <label for="nombre">Nombre:</label>
    <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $tarea->nombre) }}" required>

    <label for="descripcion">Descripción:</label>
    <textarea name="descripcion" id="descripcion">{{ old('descripcion', $tarea->descripcion) }}</textarea>

    <label for="historial">Historial:</label>
    <textarea name="historial" id="historial">{{ old('historial', $tarea->historial) }}</textarea>

    <label for="actividad">Actividad:</label>
    <select name="actividad" id="actividad">
        <option value="Configuracion" {{ $tarea->actividad == 'Configuracion' ? 'selected' : '' }}>Configuración</option>
        <option value="Desarrollo" {{ $tarea->actividad == 'Desarrollo' ? 'selected' : '' }}>Desarrollo</option>
        <option value="Prueba" {{ $tarea->actividad == 'Prueba' ? 'selected' : '' }}>Prueba</option>
        <option value="Diseño" {{ $tarea->actividad == 'Diseño' ? 'selected' : '' }}>Diseño</option>
    </select>

    <label for="asignado">Asignado a:</label>
    <input type="text" name="asignado" id="asignado" value="{{ old('asignado', $tarea->asignado) }}">

    <label for="historia_id">Historia:</label>
    <select name="historia_id" id="historia_id">
        @foreach($historias as $historia)
            <option value="{{ $historia->id }}" {{ $tarea->historia_id == $historia->id ? 'selected' : '' }}>
                {{ $historia->nombre }}
            </option>
        @endforeach
    </select>

    <button type="submit" class="btn btn-primary">Actualizar</button>
</form>
@endsection
@stop
