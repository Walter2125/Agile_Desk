<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles Sprints</title>
    <style>
        /* Fondo suave */
        body {
            font-family: Arial, sans-serif;
            background-color:rgb(135, 168, 224); /* Fondo suave, color claro */
            color: #333;
            margin: 0;
            padding: 0;
        }

        /* Contenedor principal */
        .sprint-container {
            max-width: 900px;
            margin: 30px auto;
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            box-sizing: border-box;
        }

        h2 {
            text-align: center;
            color: #2C3E50;
        }

        /* Estilos para cada sprint */
        .sprint-item {
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            background-color: #fafafa;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .sprint-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        /* Clases de estado para los sprints */
        .status-activo {
            color: #3498db;
        }

        .status-completado {
            color: #2ecc71;
        }

        .status-pendiente {
            color: #f39c12;
        }

        /* Estilo de botones */
        .details-button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 8px 15px;
            cursor: pointer;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .details-button:hover {
            background-color: #0056b3;
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .modal-content {
            background: white;
            padding: 20px;
            border-radius: 8px;
            width: 400px;
            text-align: center;
        }

        /* Cerrar botón del modal */
        .modal-content button {
            background-color: #e74c3c;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            margin-top: 15px;
        }

        .modal-content button:hover {
            background-color: #c0392b;
        }
    </style>
</head>
<body>
    <div class="sprint-container">
        <h2>Detalles de Sprints</h2>
        <div id="sprint-list">
            @foreach($sprints as $sprint)
                <div class="sprint-item">
                    <div class="sprint-title" style="font-size: 20px; font-weight: bold; color: #34495e;">
                        {{ $sprint->nombre }}
                    </div>
                    <div><strong>Inicio:</strong> {{ $sprint->fecha_inicio }}</div>
                    <div><strong>Fin:</strong> {{ $sprint->fecha_fin }}</div>

                    <!-- Mostrar el estado con clases correspondientes -->
                    @php
                        $statusClass = '';
                        if ($sprint->estado === 'EN CURSO') $statusClass = 'status-activo';
                        else if ($sprint->estado === 'FINALIZADO') $statusClass = 'status-completado';
                        else if ($sprint->estado === 'PLANEADO') $statusClass = 'status-pendiente';
                    @endphp
                    <div class="sprint-status {{ $statusClass }}">
                        <strong>Estado:</strong> {{ $sprint->estado }}
                    </div>
                    <button class="details-button" onclick="showDetails('{{ $sprint->nombre }}', 'Responsable: {{ $sprint->responsable }}')">Detalles</button>

                    <!-- Mostrar Historias y Tareas -->
                    <h3>Historias:</h3>
                    @foreach($sprint->historias as $historia)
                        <p><strong>{{ $historia->nombre }}</strong></p>
                        <h4>Tareas:</h4>
                        @foreach($historia->tareas as $tarea)
                            <p>- {{ $tarea->nombre }}</p>
                        @endforeach
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
    
    <!-- Modal -->
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