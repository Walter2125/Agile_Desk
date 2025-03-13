@extends('layout.plantilla')
@section('title','creacion')

@section('content')

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error )
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

    <form action="{{route('formulario.store')}}" method="post">
        @csrf 

       <div class="mb-3">
            <div class="col field">
                <label>Nombre de la historia:</label>
                <input type="text" class="form-control" id="nombreHistoria" name="nombre" placeholder="Ingrese el nombre" value="{{ old('nombreHistoria') }}">
            </div>
            <div class="col field" style="max-width: 120px;">
                <label># Historia:</label>
                <input type="text" id="numeroHistoria" readonly>
            </div>
       </div>
       <div class="row">
            <div class="col field">
                <label>Estado:</label>
                <input type="text" id="estadoHistoria" readonly>
            </div>
            <div class="col field">
                <label>Sprint:</label>
                <input type="number" id="sprintHistoria" name="sprint" placeholder="Número del sprint" value="{{ old('sprintHistoria') }}">
            </div>
            <div class="col field">
                <label>Trabajo estimado (horas):</label>
                <input type="number" id="trabajoEstimado" name="trabajo_estimado" placeholder="Horas estimadas">
            </div>
        </div>
        <div class="row">
            <div class="col field">
                <label>Responsable:</label>
                <input type="text" id="responsableHistoria" name="responsable" placeholder="Nombre del responsable">
            </div>
            <div class="col field">
                <label>Prioridad:</label>
                <select id="prioridadHistoria" name="prioridad" class="form-control" >
                    <option value="Alta">Alta</option>
                    <option value="Media">Media</option>
                    <option value="Baja">Baja</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col field" style="flex: 2;">
                <label>Descripción:</label>
                <textarea id="descripcionHistoria" name="descripcion" placeholder="Ingrese la descripción"></textarea>
            </div class="col field" style="flex: 1;">
            <label>Tareas:</label>
                <!-- <button onclick="agregarTarea()">Agregar Tarea</button>  Este botton creara la tarea al crud tarea-->
                <div id="listaTareas" class="tareas"></div>
                
            </div>
        </div>

        <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i>Guardar</button>
    
    </form>
@endsection