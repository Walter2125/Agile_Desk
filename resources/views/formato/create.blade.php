@extends('adminlte::page')
@section('title', 'Agile Desk')
@section("adminlte_css")

@section('adminlte_css')
    <link rel="stylesheet" href="{{ asset('style.css') }}">
@stop

@section('content')
<link href="{{ asset('css/formato.css') }}" rel="stylesheet">

    @if ($errors->any())
        <div>

            <ul class="alert alert-primary" role="alert">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ulq>
        </div>
    @endif


    <form action="{{ route('formulario.store') }}" method="post">
        @csrf
        <div class="container">
            <div class="mb-3">
                <div class="cold field">
                    <div class="col-md-8">
                        <label for="nombreHistoria">Nombre de la historia:</label>
                        <input type="text" class="form-control" id="nombreHistoria" name="nombre" placeholder="Ingrese el nombre" value="{{ old('nombre') }}">
                    </div>
                   
                   
                    <div class="col-md-4">
                        <label for="numeroHistoria"># Historia:</label>
                        <input type="text" class="form-control" id="numeroHistoria" readonly>
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="estadoHistoria">Estado:</label>
                    <input type="text" class="form-control" id="estadoHistoria" readonly>
                </div>
                <div class="col-md-4">
                    <label for="sprintHistoria">Sprint:</label><!--El sprint no debe ser requerido revisar esto en controlador -->
                    <input type="number" class="form-control" id="sprintHistoria" name="sprint" placeholder="Número del sprint" value="{{ old('sprint') }}" min="0">
                </div>
                <div class="col-md-4">
                    <label for="trabajoEstimado">Trabajo estimado (horas):</label>
                    <input type="number" name="trabajo_estimado" placeholder="Horas estimadas" value={{ old("trabajo_estimado")}} min="0" >

                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="responsableHistoria">Responsable:</label>
                    <input type="text" class="form-control" id="responsableHistoria" name="responsable" placeholder="Nombre del responsable" value="{{ old('responsable') }}" >
                </div>
                <div class="col-md-6">
                    <label for="prioridadHistoria">Prioridad:</label>
                    <select class="form-control" id="prioridadHistoria" name="prioridad">
                        <option value="Alta">Alta</option>
                        <option value="Media">Media</option>
                        <option value="Baja">Baja</option>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-12">
                    <label for="descripcionHistoria">Descripción:</label>
                    <textarea class="form-control" id="descripcionHistoria" name="descripcion" rows="3" placeholder="Ingrese la descripción" ></textarea>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-12">
                    <label for="tareas">Tareas:</label>
                    <div id="listaTareas" class="tareas"></div>
                    <!-- <button onclick="agregarTarea()" class="btn btn-secondary">Agregar Tarea</button> -->
                </div>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Guardar</button>
            </div>
        </div>
    </form>
@endsection


@stop

@section('adminlte_js')
    <script src="{{ asset('color.js') }}"></script>
@stop
