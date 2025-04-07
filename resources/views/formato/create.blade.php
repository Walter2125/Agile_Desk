@extends('adminlte::page')
@section('title', 'Agile Desk')
        @section("adminlte_css")
        <link rel="stylesheet" href="{{ asset('css/cust.css') }}">
        @endsection


@section('content')



    @if ($errors->any())
        <div role="alert" id="mi_alerta" class="w-100">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <form action="{{ route('formulario.store') }}" method="post">
    @csrf
    <br>
    <div class="container-fluid contenedor-con-borde">
        
        <div class="mb-3">
            <div class="form-group d-flex align-items-center">
                <div class="col-md-6">
                    <br>
                    <label for="nombreHistoria" class="label-custom">Nombre de la historia:</label>
                    <input type="text" class="form-control input-custom" id="nombreHistoria" name="nombre" placeholder="Ingrese el nombre" value="{{ old('nombre') }}">
                </div>
                <div class="col-md-3">
                    <br>
                    <label for="numeroHistoria" class="label-custom"># Historia:</label>
                    <input type="text" class="form-control input-custom" id="numeroHistoria" readonly>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4">
                <label for="estadoHistoria" class="label-custom">Estado:</label>
                <input type="text" class="form-control input-custom" id="estadoHistoria" readonly>
            </div>
            <div class="col-md-4">
                <label for="sprintHistoria" class="label-custom">Sprint:</label>
                <input type="number" class="form-control input-custom" id="sprintHistoria" name="sprint" placeholder="Número del sprint" value="{{ old('sprint') }}" min="0">
            </div>
            <div class="col-md-4">
                <label for="trabajoEstimado" class="label-custom">Trabajo estimado (horas):</label>
                <input type="number" name="trabajo_estimado" class="form-control input-custom" placeholder="Horas estimadas" value="{{ old('trabajo_estimado') }}" min="0" step="1" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="responsableHistoria" class="label-custom">Responsable:</label>
                <input type="text" class="form-control input-custom" id="responsableHistoria" name="responsable" placeholder="Nombre del responsable" value="{{ old('responsable') }}">
            </div>
            <div class="col-md-6">
                <label for="prioridadHistoria" class="label-custom">Prioridad:</label>
                <select class="form-control input-custom" id="prioridadHistoria" name="prioridad">
                    <option value="Alta">Alta</option>
                    <option value="Media">Media</option>
                    <option value="Baja">Baja</option>
                </select>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                <label for="descripcionHistoria" class="label-custom">Descripción:</label>
                <textarea class="form-control input-custom" id="descripcionHistoria" name="descripcion" rows="3" placeholder="Ingrese la descripción"></textarea>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                <label for="tareas" class="label-custom">Tareas:</label>
                <div id="listaTareas" class="tareas"></div>
            </div>
        </div>

        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <button type="submit" class="btn btn-custom"><i class="bi bi-save"></i> Guardar</button>
        </div>
    </div>
</form>

@endsection


