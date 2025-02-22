<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historia de Usuario</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; padding: 20px; }
        .container { max-width: 600px; margin: auto; }
        .field { margin-bottom: 10px; }
        label { font-weight: bold; }
        input, textarea, select { width: 100%; padding: 5px; margin-top: 5px; }
        .tareas { margin-top: 10px; }
        .tarea-item { margin-top: 5px; padding: 5px; border: 1px solid #ddd; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Historia de Usuario</h2>
        
        <div class="field">
            <label>Nombre de la historia:</label>
            <input type="text" id="nombreHistoria">
        </div>
        
        <div class="field">
            <label>Número de historia:</label>
            <input type="text" id="numeroHistoria" readonly>
        </div>
        
        <div class="field">
            <label>Estado:</label>
            <input type="text" id="estadoHistoria" readonly>
        </div>
        
        <div class="field">
            <label>Sprint:</label>
            <input type="number" id="sprintHistoria">
        </div>
        
        <div class="field">
            <label>Trabajo estimado (horas):</label>
            <input type="number" id="trabajoEstimado">
        </div>
        
        <div class="field">
            <label>Prioridad:</label>
            <select id="prioridadHistoria">
                <option value="Alta">Alta</option>
                <option value="Media">Media</option>
                <option value="Baja">Baja</option>
            </select>
        </div>
        
        <div class="field">
            <label>Responsable:</label>
            <input type="text" id="responsableHistoria">
        </div>
        
        <div class="field">
            <label>Descripción:</label>
            <textarea id="descripcionHistoria"></textarea>
        </div>
        
        <div class="field">
            <label>Tareas:</label>
            <div id="listaTareas" class="tareas"></div>
            <button onclick="agregarTarea()">Agregar Tarea</button>
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
</body>
</html>
