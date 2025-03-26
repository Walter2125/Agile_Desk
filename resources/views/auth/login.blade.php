<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <title>Iniciar Sesión</title>
    <link rel="icon" href="{{ asset('img/newlogo.png') }}" type="image/x-icon">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            height: 100%;
            overflow: hidden;  
            background-color: #1c314e;
        }

        .container {
            height: 100vh;
            width: 100%;  
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        #logo {
            top: 0;
            position: relative;
            width: 150px;  /* Ajusta el tamaño según tu logo */
            height: 150px;
            object-fit: contain;
            margin-bottom: 20px;
        }

        .card {
            max-width: 400px;
            width: 100%;
            padding: 30px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            border-radius: 15px;
            background-color: white;
            position: relative;
            top: -20px;  /* Sube ligeramente la card */
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <img src="{{ asset('img/newlog.png') }}" alt="logo" id="logo">
        <div class="card">
            <h2 class="text-center text-primary fw-bold mb-4">Iniciar Sesión</h2>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Correo Electrónico</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>
                <div class="mb-3 text-center">
                    <button type="submit" class="btn btn-primary w-100">Iniciar Sesión</button>
                </div>
            </form>
            <p class="text-center mt-3">
                ¿No tienes cuenta? <a href="{{ route('register') }}" class="text-primary">Regístrate aquí</a>
            </p>
        </div>
    </div>
</body>
</html>