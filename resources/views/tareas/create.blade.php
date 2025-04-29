@extends('adminlte::page')

@section('title', 'Agile Desk')

@section('adminlte_css')
    <link rel="stylesheet" href="{{ asset('css/tareas.css') }}">
@endsection

@section('Mensaje')
   
@endsection

@section('content')

<div class="container-fluid contenedor-formulario ">
   
        <form action="{{ route('tareas.store') }}" method="POST">
            @csrf
            <li class="nav-item d-flex align-items-center justify-content-between ps-3" style="padding-top: 0.4rem; padding-bottom: 0.4rem;">
                <h1 class="fw-bold mb-0" style="font-size: 2rem;">✏️ Crear Una Nueva Tarea</h1>

                <div class="d-flex flex-column align-items-end col-md-4">
                <label for="historia_id" class="form-label mb-1">Historia Asociada</label>
                <input type="hidden" name="historia_id" value="{{ $historia->id ?? '' }}">
                <input type="text" class="form-control" id="historia_nombre" value="{{ $historia->nombre ?? '' }}" readonly>
                </div>
            </li>
            
            <div class="col md">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>

            <div class="row g-2">
                    <div class="col md">
                        <label for="asignado" class="form-label">Asignado a</label>
                        <input type="text" class="form-control" id="asignado" name="asignado">
                    </div>
                    <div class="col-md-4">
                    <div class="container mt-4">
                        <label for="actividad" class="form-label mb-2">Actividad</label>
                        <select class="form-select form-select-lg" aria-label="Default select example" id="actividad" name="actividad" required>
                            <option value="Configuracion">Configuración</option>
                            <option value="Desarrollo">Desarrollo</option>
                            <option value="Prueba">Prueba</option>
                            <option value="Diseño">Diseño</option>
                        </select>
                    </div>
                    </div>

                    

            </div>
            <div class="row g-2">
            <div class="col mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea class="form-control" id="descripcion" name="descripcion" rows="3"></textarea>
            </div>

            <div class="col md">
                <label for="historial" class="form-label">Historial</label>
                <textarea class="form-control" id="historial" name="historial" rows="3"></textarea>
            </div>

            </div>

            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <div class="row mb-3">
                <div class="col-md">
                <a href="{{ route('formulario.show', $historia->id) }}" class="btn btn-secondary me-2">Volver</a>
                <button class="btn btn-primary boton-guardar" type="submit">Guardar</button>
                
                </div>
                </div>
            </div>
        </form>
</div>
<script>
   
    if (performance.navigation.type === 2 || performance.getEntriesByType("navigation")[0]?.type === "back_forward") {
        window.location.href = "{{ route('tareas.index') }}";
    }
</script>
@endsection