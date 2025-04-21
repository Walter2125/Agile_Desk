<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="icon" href="{{ asset('img/newlogo.png') }}" type="image/x-icon">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            height: 100%;
            overflow: hidden;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #1c314e;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-container {
            background-color: #fff;
            padding: 40px 30px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        #logo {
            width: 120px;
            margin-bottom: 25px;
        }

        h2 {
            font-weight: bold;
            color: #007bff;
            margin-bottom: 30px;
        }

        .form-control {
            border-radius: 10px;
        }

        .btn-primary {
            width: 100%;
            border-radius: 10px;
            font-weight: bold;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .form-group {
            text-align: left;
        }

        /* MEDIA QUERIES PERSONALIZADAS */
        @media (max-width: 768px) {
            .login-container {
                padding: 30px 20px;
                border-radius: 15px;
            }

            #logo {
                width: 100px;
            }

            h2 {
                font-size: 22px;
                margin-bottom: 20px;
            }

            .form-label {
                font-size: 14px;
            }

            .form-control {
                font-size: 14px;
            }

            .btn-primary {
                font-size: 14px;
            }
        }

        @media (max-width: 480px) {
            .login-container {
                padding: 25px 15px;
            }

            #logo {
                width: 80px;
            }

            h2 {
                font-size: 20px;
            }
        }

        @media (min-width: 1200px) {
            .login-container {
                padding: 50px;
            }

            h2 {
                font-size: 28px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <img src="{{ asset('img/newlog.png') }}" alt="Logo" id="logo">
        <h2>Iniciar Sesión</h2>
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group mb-3">
                <label for="email" class="form-label">Correo electrónico</label>
                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
            </div>

            <div class="form-group mb-4">
                <label for="password" class="form-label">Contraseña</label>
                <input id="password" type="password" class="form-control" name="password" required>
            </div>

            <button type="submit" class="btn btn-primary mb-3">Ingresar</button>

            <p class="mt-3">
                <a href="{{ route('password.request') }}" class="text-decoration-none text-primary">
                ¿Olvidaste tu contraseña?
                </a>
            </p>

            <p class="mt-3">¿No tienes cuenta? <a href="{{ route('register') }}" class="text-decoration-none text-primary">Regístrate aquí</a></p>
        </form>
    </div>
</body>
</html>
