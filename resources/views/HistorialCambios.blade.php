<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Cambios</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #bfd0e4;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            max-width: 900px;
            width: 100%;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
        }

        .filters {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            justify-content: center;
            margin-bottom: 20px;
        }

        .filters input, .filters select, .filters button {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .filters button {
            background-color: #007bff;
            color: white;
            cursor: pointer;
            border: none;
            transition: 0.3s;
        }

        .filters button:hover {
            background-color: #0056b3;
        }

        .clear-btn {
            background-color: #dc3545;
        }

        .clear-btn:hover {
            background-color: #c82333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 8px;
            overflow: hidden;
        }

        th, td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .btn-revert {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 8px;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn-revert:hover {
            background-color: #c82333;
        }

        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            margin-top: 15px;
        }

        .pagination button {
            padding: 8px 12px;
            border: none;
            background-color: #28a745;
            color: white;
            cursor: pointer;
            border-radius: 5px;
            transition: 0.3s;
        }

        .pagination button:disabled {
            background-color: #ccc;
            cursor: not-allowed;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Historial de Cambios</h2>
        <div class="filters">
            <input type="text" id="usuarioFiltro" placeholder="Usuario">
            <select id="accionFiltro">
                <option value="">Todas las acciones</option>
                <option value="Creación">Creación</option>
                <option value="Edición">Edición</option>
                <option value="Eliminación">Eliminación</option>
            </select>
            <input type="date" id="fechaFiltro">
            <button onclick="fetchHistorial()">Filtrar</button>
            <button class="clear-btn" onclick="limpiarFiltros()">Limpiar</button>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Usuario</th>
                    <th>Acción</th>
                    <th>Detalles</th>
                    <th>Revertir</th>
                </tr>
            </thead>
            <tbody id="historialBody"></tbody>
        </table>

        <div class="pagination">
            <button id="prevPage" onclick="cambiarPagina(-1)" disabled>Anterior</button>
            <span id="paginaActual">1</span>
            <button id="nextPage" onclick="cambiarPagina(1)" disabled>Siguiente</button>
        </div>
    </div>

    <script>
        let paginaActual = 1;

        // Función para limpiar filtros
        function limpiarFiltros() {
            document.getElementById("usuarioFiltro").value = "";
            document.getElementById("accionFiltro").value = "";
            document.getElementById("fechaFiltro").value = "";
            fetchHistorial();
        }

        // Función para obtener el historial de cambios filtrado y paginado
        function fetchHistorial() {
            const usuario = document.getElementById("usuarioFiltro").value;
            const accion = document.getElementById("accionFiltro").value;
            const fecha = document.getElementById("fechaFiltro").value;

            // Asegurarse de que la URL se construye correctamente
            const url = `/historialcambios?usuario=${encodeURIComponent(usuario)}&accion=${encodeURIComponent(accion)}&fecha=${encodeURIComponent(fecha)}&page=${paginaActual}`;

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    const tbody = document.getElementById("historialBody");
                    tbody.innerHTML = ''; // Limpiar contenido actual

                    // Comprobar si hay datos
                    if (data.data.length === 0) {
                        tbody.innerHTML = '<tr><td colspan="5">No hay resultados para mostrar.</td></tr>';
                    } else {
                        data.data.forEach(item => {
                            const row = document.createElement("tr");
                            row.innerHTML = `
                                <td>${item.fecha}</td>
                                <td>${item.usuario}</td>
                                <td>${item.accion}</td>
                                <td>${item.detalles}</td>
                                <td><button class="btn-revert" onclick="revertirCambio(${item.id})">Revertir</button></td>
                            `;
                            tbody.appendChild(row);
                        });
                    }

                    // Actualizar la paginación
                    document.getElementById("paginaActual").textContent = data.current_page;
                    document.getElementById("prevPage").disabled = !data.prev_page_url;
                    document.getElementById("nextPage").disabled = !data.next_page_url;
                })
                .catch(error => {
                    console.error('Error al obtener los datos:', error);
                    alert('Hubo un problema al cargar los datos.');
                });
        }

        // Función para cambiar la página de resultados
        function cambiarPagina(incremento) {
            paginaActual += incremento;
            fetchHistorial();
        }

        // Función para revertir un cambio
        function revertirCambio(id) {
            // Lógica para revertir el cambio (enviar al backend)
            fetch(`/historialcambios/revertir/${id}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Cambio revertido con éxito');
                    fetchHistorial(); // Refrescar la tabla
                } else {
                    alert('Error al revertir el cambio');
                }
            });
        }

        // Cargar los datos al cargar la página
        document.addEventListener('DOMContentLoaded', fetchHistorial);
    </script>
</body>
</html>