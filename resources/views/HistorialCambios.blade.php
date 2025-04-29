@extends('adminlte::page')

@section('title', 'Historial de Cambios')

@section('adminlte_css')
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/historialC.css') }}">
@stop

@section('content')
<div class="container">
    <h2>Historial de Cambios</h2>
    <h5>Historial de cambios del proyecto: {{ $project->name }}</h1>

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
