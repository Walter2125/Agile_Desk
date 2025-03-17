<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <title>Iniciar Sesión</title>
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card shadow-lg p-4 rounded" style="width: 400px;">
            <div class="text-center mb-4">
                <h2 class="fw-bold text-primary">Iniciar Sesión</h2>
            </div>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label fw-bold">Correo Electrónico</label>
                    <input id="email" type="email" class="form-control" name="email" required autofocus>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label fw-bold">Contraseña</label>
                    <input id="password" type="password" class="form-control" name="password" required>
                </div>
                <div class="mb-3 text-center">
                    <button type="submit" class="btn btn-primary w-100">Iniciar Sesión</button>
                </div>
            </form>
            <div class="text-center">
                ¿No tienes cuenta? <a href="{{ route('register') }}">Regístrate aquí</a>
            </div>
        </div>
    </div>
</body>
</html>
