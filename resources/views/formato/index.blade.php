@extends('layout.plantilla')

@section('title','formato historia')

@section('content')

@if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
  <br>
 

@foreach ($historias as $historia)
        <table class="table">
            <thead>
                <tr>
                    <th scope="col"><a href="{{ route('formulario.edit', $historia->id) }}" class="btn btn-primary">
                        <i class="bi bi-pencil"></i> Editar
                        </a></th>
                    <th scope="col"><form action="{{ route('formulario.destroy',$historia->id) }}" method="post">
                        @csrf
                        @method('DELETE')<button type="submit" class="btn btn-danger btn-sm">
                        <i class="bi bi-trash"></i> Eliminar</button>
                        </form></th>
                </tr>
            </thead>
            <tbody>
            </tbody>

        </table>
    
@endforeach

    <div>
    <a href="{{ route('formulario.create') }}" class="btn btn-primary"><i class="bi bi-plus"></i>Crear</a>
    </div>
    <div>
        <a href="{{ route('formulario.edit', $historia->id) }}" class="btn btn-primary"><i class="bi bi-plus"></i>editar</a>
    </div>

        <div class="row">
            <div class="col field">
                <label>Tareas:</label>
                <button onclick="agregarTarea()">Agregar Tarea</button>
                <div id="listaTareas" class="tareas"></div>
            </div>
        </div>

    </div>
</div>
</div>

<script>
    function abrirModal() {
        document.getElementById("miModal").style.display = "flex";
    }

    function cerrarModal() {
        document.getElementById("miModal").style.display = "none";
    }

    function agregarTarea() {
        let lista = document.getElementById("listaTareas");
        let nuevaTarea = document.createElement("div");
        nuevaTarea.className = "tarea-item";
        nuevaTarea.innerHTML = `<input type="text" placeholder="Descripción de la tarea">`;
        lista.appendChild(nuevaTarea);
    }
</script>
@endsection