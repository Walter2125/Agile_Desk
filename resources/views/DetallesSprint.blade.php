<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles Sprints</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .sprint-container { max-width: 600px; margin: 20px auto; }
        .sprint-item { border: 1px solid #ddd; padding: 10px; margin-bottom: 10px; }
        .status-activo { color: blue; }
        .status-completado { color: green; }
        .status-pendiente { color: orange; }
        .details-button { background-color: #007bff; color: white; border: none; padding: 5px 10px; cursor: pointer; }
        .modal { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); justify-content: center; align-items: center; }
        .modal-content { background: white; padding: 20px; border-radius: 5px; }
    </style>
</head>
<body>
    <div class="sprint-container">
        <h2>Detalles de Sprints</h2>
        <div id="sprint-list">
            @foreach($sprints as $sprint)
                <div class="sprint-item">
                    <div class="sprint-title">{{ $sprint->nombre }}</div>
                    <div>Inicio: {{ $sprint->fecha_inicio }}</div>
                    <div>Fin: {{ $sprint->fecha_fin }}</div>

                    <!-- Mostrar el estado con clases correspondientes -->
                    @php
                        $statusClass = '';
                        if ($sprint->estado === 'EN CURSO') $statusClass = 'status-activo';
                        else if ($sprint->estado === 'FINALIZADO') $statusClass = 'status-completado';
                        else if ($sprint->estado === 'PLANEADO') $statusClass = 'status-pendiente';
                    @endphp
                    <div class="sprint-status {{ $statusClass }}">{{ $sprint->estado }}</div>
                    <button class="details-button" onclick="showDetails('{{ $sprint->nombre }}', 'Responsable: {{ $sprint->responsable }}')">Detalles</button>
                    
                    <!-- Mostrar Historias y Tareas -->
                    <h3>Historias:</h3>
                    @foreach($sprint->historias as $historia)
                        <p>{{ $historia->nombre }}</p>
                        <h4>Tareas:</h4>
                        @foreach($historia->tareas as $tarea)
                            <p>{{ $tarea->nombre }}</p>
                        @endforeach
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
    
    <div id="modal" class="modal" onclick="closeModal()">
        <div class="modal-content">
            <h3 id="modal-title"></h3>
            <p id="modal-body"></p>
            <button onclick="closeModal()">Cerrar</button>
        </div>
    </div>
    
    <script>
        function showDetails(title, body) {
            document.getElementById('modal-title').innerText = title;
            document.getElementById('modal-body').innerText = body;
            document.getElementById('modal').style.display = 'flex';
        }

        function closeModal() {
            document.getElementById('modal').style.display = 'none';
        }
    </script>
</body>
</html>