
@extends('adminlte::page')
@section('title', 'Agile Desk')
        @section("adminlte_css")
        <link rel="stylesheet" href="{{ asset('css/cust.css') }}">
        @endsection

@section('content')
<link href="{{ asset('css/formato.css') }}" rel="stylesheet">


@if ($errors->any())
        <div role="alert" id="mi_alerta" class="w-100">
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
        
        <div class="container">
            <div class="mb-3">
                    <div class="cold field">
                        <div class="col-md-8">
                        <label>Nombre de la historia:</label>
                        <input type="text" class="form-control" name="nombre" value="{{ old('nombre', $historia->nombre) }}" placeholder="Ingrese el nombre">
                        </div>

                    </div class="col-md-4">
                <div class="col field" style="max-width: 120px;">
                    <label># Historia:</label>
                    <input type="text" value="{{ $historia->id }}" readonly>
                </div>
            </div>

            <div class="row">
                <div class="col field">
                    <label>Estado:</label>
                    <input type="text" value="Pendiente" readonly>
                </div>
                <div class="col field">
                    <label>Sprint:</label>
                    <input type="number" name="sprint" value="{{ old('sprint', $historia->sprint) }}" placeholder="Número del sprint" min="0">
                </div>
                <div class="col field">
                    <label>Trabajo estimado (horas):</label>
                    <input type="number" name="trabajo_estimado" value="{{ old('trabajo_estimado', $historia->trabajo_estimado) }}" placeholder="Horas estimadas" min="0" step="1" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                </div>
            </div>

            <div class="row">
                <div class="col field">
                    <label>Responsable:</label>
                    <input type="text" name="responsable" value="{{ old('responsable', $historia->responsable) }}" placeholder="Nombre del responsable">
                </div>
                <div class="col field">
                    <label>Prioridad:</label>
                    <select name="prioridad" class="form-control">
                        <option value="Alta" {{ $historia->prioridad == 'Alta' ? 'selected' : '' }}>Alta</option>
                        <option value="Media" {{ $historia->prioridad == 'Media' ? 'selected' : '' }}>Media</option>
                        <option value="Baja" {{ $historia->prioridad == 'Baja' ? 'selected' : '' }}>Baja</option>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col field" style="flex: 2;">
                    <label>Descripción:</label>
                    <textarea name="descripcion" placeholder="Ingrese la descripción">{{ old('descripcion', $historia->descripcion) }}</textarea>
                </div>
            </div>

           
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary" >
                        <i class="bi bi-save"></i>
                        Actualizar
                    </button>
                </div>
           
        </div>
    </form>

@endsection

