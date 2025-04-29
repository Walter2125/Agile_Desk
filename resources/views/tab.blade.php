<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kanban Estilo Jira</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="{{ asset('style.css') }}">
</head>
<body>
<div class="kanban-board">
    <!-- Columna "Pendiente" -->
    <div class="kanban-column">
        <div class="kanban-column-header">
            Pendiente
            <div class="dropdown">
                <span>&#x22EE;</span>
                <div class="dropdown-content">
                    <a href="#">Editar</a>
                    <a href="#">Eliminar</a>
                </div>
            </div>
        </div>
        <div class="kanban-column-content">
            <div class="kanban-card">Tarea 1</div>
            <div class="kanban-card">Tarea 2</div>
        </div>
    </div>
    <!-- Columna "En Progreso" -->
    <div class="kanban-column">
        <div class="kanban-column-header">
            En Progreso
            <div class="dropdown">
                <span>&#x22EE;</span>
                <div class="dropdown-content">
                    <a href="#">Editar</a>
                    <a href="#">Eliminar</a>
                </div>
            </div>
        </div>
        <div class="kanban-column-content">
            <div class="kanban-card">Tarea 3</div>
        </div>
    </div>
    <!-- Columna "Finalizada" -->
    <div class="kanban-column">
        <div class="kanban-column-header">
            Finalizada
            <div class="dropdown">
                <span>&#x22EE;</span>
                <div class="dropdown-content">
                    <a href="#">Editar</a>
                    <a href="#">Eliminar</a>
                </div>
            </div>
        </div>
        <div class="kanban-column-content">
            <div class="kanban-card">Tarea 4</div>
        </div>
    </div>
    <!-- Botón para agregar nueva columna -->
    <div class="kanban-add-column">
        <button class="add-button">+</button>
    </div>
</div>

</body>
</html>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Selecciona todos los elementos que participarán en la distribución:
        const board = document.querySelector('.kanban-board');
        const columns = board.querySelectorAll('.kanban-column, .kanban-add-column');

        // Si hay 4 elementos o menos, se distribuyen de forma equitativa
        if (columns.length <= 4) {
            board.style.overflowX = "hidden";
            columns.forEach(col => {
                col.style.flex = "1 1 0";
            });
        } else {
            // Más de 4 elementos: ancho fijo y scroll horizontal
            board.style.overflowX = "auto";
            columns.forEach(col => {
                col.style.flex = "0 0 300px";
            });
        }
    });
</script>
