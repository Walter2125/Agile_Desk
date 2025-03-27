<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Cambios</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <style>
        /* Estilos globales */
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color:rgb(120, 136, 163);
            color: #333;
        }

        .container {
            width: 90%;
            max-width: 1000px;
            margin: 50px auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
            font-size: 2rem;
            margin-bottom: 20px;
        }

        .filters {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
        }

        .filters input,
        .filters select,
        .filters button {
            padding: 12px 15px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ccc;
            width: 100%;
            max-width: 250px;
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

        .filters .clear-btn {
            background-color: #dc3545;
        }

        .filters .clear-btn:hover {
            background-color: #c82333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #007bff;
            color: white;
            font-size: 1rem;
        }

        tr:hover {
            background-color: #f9f9f9;
        }

        .btn-revert {
            background-color: #dc3545;
            color: white;
            padding: 8px 12px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn-revert:hover {
            background-color: #c82333;
        }

        .pagination {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 20px;
        }

        .pagination button {
            padding: 8px 16px;
            border: none;
            background-color: #28a745;
            color: white;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }

        .pagination button:disabled {
            background-color: #ccc;
            cursor: not-allowed;
        }

        .pagination span {
            align-self: center;
            font-size: 1.2rem;
            color: #333;
        }

        .empty-msg {
            text-align: center;
            font-size: 1.2rem;
            color: #777;
            padding: 20px;
            font-style: italic;
        }
    </style>
</head>

<body>

    <div class="container">
        <h2>Historial de Cambios</h2>

        <!-- Filtros -->
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

        <!-- Tabla de Historial de Cambios -->
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
            <tbody>
                @forelse($historial as $item)
                    <tr>
                        <td>{{ $item->fecha }}</td>
                        <td>{{ $item->usuario }}</td>
                        <td>{{ $item->accion }}</td>
                        <td>{{ $item->detalles }}</td>
                        <td>
                            <form action="{{ route('historialcambios.revertir', $item->id) }}" method="POST">
                                @csrf
                                @method('POST')
                                <button type="submit" class="btn-revert">Revertir</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="empty-msg">No hay resultados para mostrar.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Paginación -->
        <div class="pagination">
            @if($historial->previousPageUrl())
                <button onclick="cambiarPagina(-1)">Anterior</button>
            @else
                <button disabled>Anterior</button>
            @endif

            <span>{{ $historial->currentPage() }} de {{ $historial->lastPage() }}</span>

            @if($historial->nextPageUrl())
                <button onclick="cambiarPagina(1)">Siguiente</button>
            @else
                <button disabled>Siguiente</button>
            @endif
        </div>
    </div>

    <script>
        let paginaActual = {{ $historial->currentPage() }};

        function cambiarPagina(incremento) {
            paginaActual += incremento;
            fetchHistorial();
        }

        function limpiarFiltros() {
            document.getElementById("usuarioFiltro").value = "";
            document.getElementById("accionFiltro").value = "";
            document.getElementById("fechaFiltro").value = "";
            fetchHistorial();
        }

        function fetchHistorial() {
            const usuario = document.getElementById("usuarioFiltro").value;
            const accion = document.getElementById("accionFiltro").value;
            const fecha = document.getElementById("fechaFiltro").value;

            const url = `/historialcambios?usuario=${encodeURIComponent(usuario)}&accion=${encodeURIComponent(accion)}&fecha=${encodeURIComponent(fecha)}&page=${paginaActual}`;

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    const tbody = document.querySelector("table tbody");
                    tbody.innerHTML = '';

                    if (data.data.length === 0) {
                        tbody.innerHTML = '<tr><td colspan="5" class="empty-msg">No hay resultados para mostrar.</td></tr>';
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

                    document.querySelector(".pagination span").textContent = `${data.current_page} de ${data.last_page}`;
                    document.querySelector(".pagination button:first-child").disabled = !data.prev_page_url;
                    document.querySelector(".pagination button:last-child").disabled = !data.next_page_url;
                })
                .catch(error => {
                    console.error('Error al obtener los datos:', error);
                    alert('Hubo un problema al cargar los datos.');
                });
        }

        document.addEventListener('DOMContentLoaded', fetchHistorial);
    </script>

</body>
</html>