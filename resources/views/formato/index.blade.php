@extends('layout.plantilla')

@section('title','formato historia')

@section('content')

<div class="container">
        <h2>Historia de Usuario</h2>
        
        <div class="row">
            <div class="col field">
                <label>Nombre de la historia:</label>
                <input type="text" id="nombreHistoria" placeholder="Ingrese el nombre">
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
                <input type="number" id="sprintHistoria" placeholder="Número del sprint">
            </div>
            <div class="col field">
                <label>Trabajo estimado (horas):</label>
                <input type="number" id="trabajoEstimado" placeholder="Horas estimadas">
            </div>
        </div>
        
        <div class="row">
            <div class="col field">
                <label>Responsable:</label>
                <input type="text" id="responsableHistoria" placeholder="Nombre del responsable">
            </div>
            <div class="col field">
                <label>Prioridad:</label>
                <select id="prioridadHistoria">
                    <option value="Alta">Alta</option>
                    <option value="Media">Media</option>
                    <option value="Baja">Baja</option>
                </select>
            </div>
        </div>
        
        <div class="row">
            <div class="col field" style="flex: 2;">
                <label>Descripción:</label>
                <textarea id="descripcionHistoria" placeholder="Ingrese la descripción"></textarea>
            </div>
            <div class="col field" style="flex: 1;">
                <label>Tareas:</label>
                <div id="listaTareas" class="tareas"></div>
                <button onclick="agregarTarea()">Agregar Tarea</button>
            </div>
        </div>
    </div>
    
    <script>
        function agregarTarea() {
            let lista = document.getElementById("listaTareas");
            let nuevaTarea = document.createElement("div");
            nuevaTarea.className = "tarea-item";
            nuevaTarea.innerHTML = `<input type="text" placeholder="Descripción de la tarea">`;
            lista.appendChild(nuevaTarea);
        }
    </script>

        </div>

@endsection