<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Bienvenido, Usuario</h1>
        <p>Esta es la vista principal para usuarios normales.</p>

        <!-- Botones para crear proyecto y sprint -->
        <div class="mb-3">
            <a href="{{ route('projects.create') }}" class="btn btn-primary">Crear Proyecto</a>
            <a href="{{ route('custom.login.form') }}" class="btn btn-secondary">Iniciar Sesión</a>
        </div>

        <!-- Botón para cerrar sesión -->
        <a href="{{ route('custom.logout') }}" class="btn btn-danger" 
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            Cerrar sesión
        </a>
        <form id="logout-form" action="{{ route('custom.logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>
</body>
</html>