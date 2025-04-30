@extends('adminlte::page')
@section('title', 'Agile Desk')

@section('Mensaje')

@endsection

@section('adminlte_css')
<link rel="stylesheet" href="{{ asset('css/cust.css') }}">
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
@stop

@section('content')

    <div class="fondo-formulario">

                @if ($errors->any())
                    <div role="alert" id="mi_alerta" class="container-fluid w-100">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Ahora la ruta recibe el parámetro tablero --}}
                <form action="{{ route('formulario.store', ['tablero' => $tablero->id, 'columna' => $columna->id]) }}" method="post">
                    @csrf
                    <div class="container-fluid contenedor-con-borde">
                    <li class="nav-item d-flex align-items-center justify-content-between ps-3" style="padding-top: 0.4rem; padding-bottom: 0.4rem;">
                        <h1 class="fw-bold mb-0" style="font-size: 2rem;">🚀 Crear Nueva Historia</h1>
                        <div class="form-floating" style="width: 150px;">
                            <input type="text" class="form-control input-custom" id="numeroHistoria" placeholder="Numero de Historia" readonly>
                            <label for="numeroHistoria"></label>
                        </div>
                    </li>
                            <div class="col-md">
                                <label for="nombreHistoria" class="label-custom">Nombre de la historia:</label>
                                <input type="text"
                                    class="form-control input-custom"
                                    id="nombreHistoria"
                                    name="nombre"
                                    placeholder="Ingrese el nombre"
                                    value="{{ old('nombre') }}">
                            </div>
                            <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label for="estadoHistoria" class="label-custom">Estado:</label>
                                        <input type="text" class="form-control input-custom" id="estadoHistoria" readonly>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="sprintHistoria" class="label-custom">Sprint:</label>
                                        <input type="number"
                                            class="form-control input-custom"
                                            id="sprintHistoria"
                                            name="sprint"
                                            placeholder="Número del sprint"
                                            value="{{ old('sprint') }}"
                                            min="0">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="trabajoEstimado" class="label-custom">Trabajo estimado (horas):</label>
                                        <input type="number"
                                            name="trabajo_estimado"
                                            class="form-control input-custom"
                                            placeholder="Horas estimadas"
                                            value="{{ old('trabajo_estimado') }}"
                                            min="0"
                                            step="1"
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="responsableHistoria" class="label-custom">Responsable:</label>
                                    <input type="text"
                                        class="form-control input-custom"
                                        id="responsableHistoria"
                                        name="responsable"
                                        placeholder="Nombre del responsable"
                                        value="{{ old('responsable') }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="prioridadHistoria" class="label-custom">Prioridad:</label>
                                    <select class="form-control input-custom"
                                            id="prioridadHistoria"
                                            name="prioridad">
                                        <option value="Alta">Alta</option>
                                        <option value="Media">Media</option>
                                        <option value="Baja">Baja</option>
                                    </select>
                                </div>
                            </div>
                                <div class="row mb-3">
                                <div class="col-md">
                                    <label for="descripcionHistoria" class="label-custom">Descripción:</label>
                                    <textarea class="form-control input-custom"
                                            id="descripcionHistoria"
                                            name="descripcion"
                                            rows="3"
                                            placeholder="Ingrese la descripción">{{ old('descripcion') }}</textarea>
                                </div>
                            </div>
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <div class="row mb-3">
                                <div class="col-md">
                                    {{-- Enlace de regreso con tablero --}}
                                    <a href="{{ route('tableros.show', $tablero->id) }}"
                                    class="btn btn-secondary me-2">
                                        Volver
                                    </a>
                                    <button class="btn btn-primary" type="submit">Guardar</button>
                                </div>
                            </div>
                        </div>

                    </div>
                </form>
    </div>

@endsection

@section('adminlte_js')
<script src="{{ asset('js/color.js') }}"></script>
@stop
