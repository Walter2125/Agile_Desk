@extends('adminlte::page')
@section('title', 'Editar Historia')
   @section('Mensaje')
   <li class="nav-item d-flex align-items-center ps-3" style="padding-top: 0.4rem; padding-bottom: 0.4rem;">
        <span class="fw-bold" style="font-size: 2rem;">
        Editar esta historia
        </span>
    </li>
   @endsection

@section("adminlte_css")
    <link rel="stylesheet" href="{{ asset('css/cust.css') }}">
@endsection

@section('content')

    @if ($errors->any())
        <div role="alert" id="mi_alerta" class="container-fluid w-100">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('formulario.update', $historia->id) }}" method="POST">
        @csrf
        @method('PATCH')

        <div class="container-fluid contenedor-con-borde">
            <div class="row g-2">
                <div class="col-md-3">
                    <label for="numeroHistoria" class="label-custom"># Historia:</label>
                    <input type="text" class="form-control input-custom" id="numeroHistoria" value="{{ $historia->id }}" readonly>
                </div>
                <div class="col-md">
                    <label for="nombreHistoria" class="label-custom">Nombre de la historia:</label>
                    <input type="text" class="form-control input-custom" id="nombreHistoria" name="nombre" value="{{ old('nombre', $historia->nombre) }}" placeholder="Ingrese el nombre">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="estadoHistoria" class="label-custom">Estado:</label>
                    <input type="text" class="form-control input-custom" id="estadoHistoria" value="Pendiente" readonly>
                </div>
                <div class="col-md-4">
                    <label for="sprintHistoria" class="label-custom">Sprint:</label>
                    <input type="number" class="form-control input-custom" id="sprintHistoria" name="sprint" value="{{ old('sprint', $historia->sprint) }}" placeholder="Número del sprint" min="0">
                </div>
                <div class="col-md-4">
                    <label for="trabajoEstimado" class="label-custom">Trabajo estimado (horas):</label>
                    <input type="number" name="trabajo_estimado" class="form-control input-custom" id="trabajoEstimado" value="{{ old('trabajo_estimado', $historia->trabajo_estimado) }}" placeholder="Horas estimadas" min="0" step="1" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="responsableHistoria" class="label-custom">Responsable:</label>
                    <input type="text" class="form-control input-custom" id="responsableHistoria" name="responsable" value="{{ old('responsable', $historia->responsable) }}" placeholder="Nombre del responsable">
                </div>
                <div class="col-md-6">
                    <label for="prioridadHistoria" class="label-custom">Prioridad:</label>
                    <select class="form-control input-custom" id="prioridadHistoria" name="prioridad">
                        <option value="Alta" {{ $historia->prioridad == 'Alta' ? 'selected' : '' }}>Alta</option>
                        <option value="Media" {{ $historia->prioridad == 'Media' ? 'selected' : '' }}>Media</option>
                        <option value="Baja" {{ $historia->prioridad == 'Baja' ? 'selected' : '' }}>Baja</option>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md">
                    <label for="descripcionHistoria" class="label-custom">Descripción:</label>
                    <textarea class="form-control input-custom" id="descripcionHistoria" name="descripcion" rows="3" placeholder="Ingrese la descripción">{{ old('descripcion', $historia->descripcion) }}</textarea>
                </div>
            </div>

            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <div class="row mb-3">
                <div class="col-md">
                <a href="{{ route('tablero') }}" class="btn btn-secondary me-2">Volver</a>
                <button class="btn btn-primary" type="submit">Actualizar</button>
                
                </div>
                </div>
            </div>
                        

           
            </div>

        </div>
    </form>
@endsection


