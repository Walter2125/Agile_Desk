@extends('adminlte::page')
@section('title', 'Agile Desk')
@section("adminlte_css")
@section('Mensaje') 
    <li class="nav-item d-flex align-items-center ps-3 mensaje-titulo">
        <span class="titulo-formulario">
        @if (isset($historia))
    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
    <h2>Tareas de la historia: {{ $historia->nombre }}</h2>
</div>

    @else
        <h2>Todas las tareas</h2>
    @endif
        </span>
    </li>
@endsection
<!-- CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


    @section('content')

            @if(session('fromCreate'))
            <script>
               
                history.pushState(null, "", location.href);
                window.addEventListener("popstate", function () {
                    location.href = "{{ route('tareas.index') }}";
                });
            </script>
        @endif


    @if (session('success'))
        <div id="mi_alerta" class="alert alert-success">
            {{ session('success') }}
        </div>
        <script>
                setTimeout(function() {
                    document.getElementById('mi_alerta').style.display = 'none';
                }, 5000); 
            </script>
    @endif


   @if (isset($historia))
    <!-- Si estamos dentro de una historia, mostramos el botón de "Ver todas las tareas" -->
    <div class="row mb-3">
        <div class="d-flex justify-content-md-end">
            <a href="{{ route('tablero') }}" class="btn btn-secondary mt-4 mb-4 me-2 ">Atras</a>
            <a href="{{ route('tareas.index') }}" class="btn btn-secondary mt-4 mb-4">Ver todas las tareas</a>
        </div>
    </div>
@else
    <!-- Si estamos en la vista de "Todas las tareas", mostramos un botón para regresar -->
    <div class="row md-3">
        <div class="d-flex justify-content-md-end">
            <a href="{{ route('tablero') }}" class="btn btn-secondary mt-4 mb-4">Atras</a>
        </div>
    </div>
@endif

<!-- Tabla responsiva -->
<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Nombre</th>
                <th scope="col">Descripcion</th>
                <th scope="col">Historial</th>
                <th scope="col">Actividad</th>
                <th scope="col">Asignado</th> 
                <th scope="col">Historia</th>
                <th scope="col">Botones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ( $tareas as $tarea )
            <tr>
                <th scope="row">{{ $tarea->nombre }}</th>
                <td>{{ $tarea->descripcion }}</td>
                <td>{{ $tarea->historial }}</td>
                <td>{{ $tarea->actividad }}</td>
                <td>{{ $tarea->asignado }}</td>
                <td>{{ $tarea->historia ? $tarea->historia->nombre : 'Sin historia' }}</td>
                <td>
                    <!-- Botones ajustados a tamaño pequeño -->
                          <div class="row mb-3">
                          <div class="d-flex justify-content-md-end">
                                <a href="{{ route('tareas.edit', $tarea->id) }}" class="btn btn-primary w-100 mb-2 me-2">Edit</a>
                                <button type="button" 
                                        class="btn btn-danger w-100 mb-2 me-2" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#modalEliminar" 
                                        data-id="{{ $tarea->id }}" 
                                        data-nombre="{{ $tarea->nombre }}">
                                    Eliminar
                                </button>
                                <a href="{{ route('tareas.show', $tarea->id) }}" class="btn btn-info w-100 mb-2">Ver</a>
                          </div>
                          </div>
                  </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>





    
    <div class="modal fade" id="modalEliminar" tabindex="-1" aria-labelledby="modalEliminarLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="formEliminar" method="POST">
        @csrf
        @method('DELETE')
        <div class="modal-header">
          <h5 class="modal-title" id="modalEliminarLabel">Confirmar eliminación</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          ¿Estás seguro de que deseas eliminar <strong id="nombreTarea"></strong>?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-danger">Eliminar</button>
        </div>
      </form>
    </div>
  </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var modalEliminar = document.getElementById('modalEliminar');
    modalEliminar.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var tareaId = button.getAttribute('data-id');
        var tareaNombre = button.getAttribute('data-nombre');

        var form = document.getElementById('formEliminar');
        form.action = '/tareas/' + tareaId;

        var nombreSpan = document.getElementById('nombreTarea');
        nombreSpan.textContent = tareaNombre;
    });
});
</script>


    </tbody>
</table>


@endsection
@stop