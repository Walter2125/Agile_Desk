@extends('adminlte::page')

@section('title', 'Historial de Cambios')

@section('adminlte_css')
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
<style>
    body {
        font-family: 'Roboto', sans-serif;
        margin: 0;
        padding: 0;
        background-color: rgb(120, 136, 163);
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
        flex-wrap: wrap;
    }

    .filters input,
    .filters select,
    .filters button {
        padding: 10px 12px;
        font-size: 14px;
        border-radius: 5px;
        border: 1px solid #ccc;
        width: 100%;
        max-width: 220px;
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
        overflow-x: auto;
    }

    th, td {
        padding: 12px;
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
        padding: 6px 10px;
        border-radius: 5px;
        border: none;
        cursor: pointer;
        transition: 0.3s;
        font-size: 14px;
    }

    .btn-revert:hover {
        background-color: #c82333;
    }

    .pagination {
        display: flex;
        justify-content: center;
        gap: 5px;
        margin-top: 20px;
        font-size: 14px;
        flex-wrap: wrap;
    }

    .pagination button {
        padding: 6px 12px;
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
        font-size: 1rem;
        color: #333;
    }

    .empty-msg {
        text-align: center;
        font-size: 1rem;
        color: #777;
        padding: 20px;
        font-style: italic;
    }

    @media (max-width: 768px) {
        .filters input,
        .filters select,
        .filters button {
            max-width: 100%;
            width: 100%;
        }

        table {
            width: 100%;
            display: block;
            overflow-x: auto;
        }

        .pagination button {
            padding: 6px 10px;
            font-size: 12px;
        }

        h2 {
            font-size: 1.5rem;
        }
    }

    @media (max-width: 480px) {
        h2 {
            font-size: 1.2rem;
        }

        .filters {
            flex-direction: column;
            align-items: stretch;
        }

        .filters input,
        .filters select,
        .filters button {
            width: 100%;
            margin-bottom: 10px;
        }
    }
</style>
@stop

@section('content')
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
                <th>Sprint</th> <!-- Añadí la columna Sprint aquí -->
            </tr>
        </thead>
        <tbody>
            @forelse($historial as $item)
                <tr>
                    <td>{{ $item->fecha }}</td>
                    <td>{{ $item->usuario }}</td>
                    <td>{{ $item->accion }}</td>
                    <td>{{ $item->detalles }}</td>
                    <td>{{ $item->sprint ?? 'N/A' }}</td> <!-- Aquí se muestra el sprint o N/A si está vacío -->
                    <td>
                        
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="empty-msg">No hay resultados para mostrar.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="pagination pagination-sm">
        {{ $historial->links() }}
    </div>
</div>
@stop

@section('adminlte_js')
<script>
    // Función para aplicar los filtros y actualizar la URL
    function fetchHistorial() {
        let usuario = document.getElementById("usuarioFiltro").value;
        let accion = document.getElementById("accionFiltro").value;
        let fecha = document.getElementById("fechaFiltro").value;

        let url = new URL(window.location.href);
        if (usuario) url.searchParams.set("usuario", usuario);
        else url.searchParams.delete("usuario");

        if (accion) url.searchParams.set("accion", accion);
        else url.searchParams.delete("accion");

        if (fecha) url.searchParams.set("fecha", fecha);
        else url.searchParams.delete("fecha");

        window.location.href = url.toString();
    }

    // Función para limpiar los filtros y recargar la página sin parámetros
    function limpiarFiltros() {
        document.getElementById("usuarioFiltro").value = "";
        document.getElementById("accionFiltro").value = "";
        document.getElementById("fechaFiltro").value = "";

        let url = new URL(window.location.href);
        url.searchParams.delete("usuario");
        url.searchParams.delete("accion");
        url.searchParams.delete("fecha");

        window.location.href = url.toString();
    }

    // Opcional: Cargar los valores previos de los filtros desde la URL
    document.addEventListener("DOMContentLoaded", function () {
        let urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has("usuario")) document.getElementById("usuarioFiltro").value = urlParams.get("usuario");
        if (urlParams.has("accion")) document.getElementById("accionFiltro").value = urlParams.get("accion");
        if (urlParams.has("fecha")) document.getElementById("fechaFiltro").value = urlParams.get("fecha");
    });
</script>
@stop
