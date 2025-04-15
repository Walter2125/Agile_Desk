<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Registro</title>
    <link rel="icon" href="{{ asset('img/newlogo.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            height: 100%;
            width: 100%;
            overflow: hidden; /* Elimina cualquier posibilidad de scroll */
            background-color: #f8f9fa;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .registration-container {
            width: 100%;
            max-width: 500px;
            max-height: 100vh; /* Nunca superará el alto de la pantalla */
            padding: 20px;
            margin: 0 auto;
        }

        .registration-card {
            width: 100%;
            border-radius: 20px;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            overflow: hidden; /* Oculta cualquier contenido que se desborde */
        }

        .card-content {
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 15px; /* Espaciado uniforme entre elementos */
        }

        .logo-container {
            text-align: center;
            margin-bottom: 10px;
        }

        .logo-container img {
            width: 80px;
            height: auto;
        }

        .form-group {
            margin-bottom: 0; /* Eliminamos el margen inferior estándar */
        }

        /* Ajustes para pantallas pequeñas */
        @media (max-width: 576px) {
            .registration-container {
                padding: 10px;
            }
            
            .registration-card {
                border-radius: 10px;
            }

            .card-content {
                padding: 15px;
                gap: 12px;
            }

            .logo-container img {
                width: 70px;
            }
        }

        /* Ajustes para pantallas muy pequeñas (ej: iPhone SE) */
        @media (max-height: 600px) {
            .logo-container img {
                width: 60px;
            }
            
            h3 {
                font-size: 1.2rem !important;
                margin-bottom: 0.5rem !important;
            }
            
            .form-label {
                font-size: 0.9rem !important;
            }
            
            .form-control {
                padding: 0.375rem 0.75rem !important;
                font-size: 0.9rem !important;
            }
            
            .btn {
                padding: 0.375rem !important;
                font-size: 0.9rem !important;
            }
        }
    </style>
</head>

<body>
    <div class="registration-container">
        <div class="registration-card card">
            <div class="card-content">
                <div class="logo-container">
                    <img src="{{ asset('img/newlogo.png') }}" alt="Logo">
                    <h3 class="text-primary fw-bold mt-2">Registro de Usuario</h3>
                </div>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="form-group">
                        <label for="name" class="form-label">Nombre</label>
                        <input id="name" type="text"
                               class="form-control @error('name') is-invalid @enderror"
                               name="name" value="{{ old('name') }}" required autofocus>

                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-label">Correo electrónico</label>
                        <input id="email" type="email"
                               class="form-control @error('email') is-invalid @enderror"
                               name="email" value="{{ old('email') }}" required>

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">Contraseña</label>
                        <input id="password" type="password"
                               class="form-control @error('password') is-invalid @enderror"
                               name="password" required>

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password-confirm" class="form-label">Confirmar Contraseña</label>
                        <input id="password-confirm" type="password"
                               class="form-control" name="password_confirmation" required>
                    </div>

                    <div class="d-grid mt-2">
                        <button type="submit" class="btn btn-primary fw-bold">
                            Registrarse
                        </button>
                    </div>

                    <div class="text-center mt-2">
                        <a href="{{ route('login') }}" class="text-decoration-none text-primary">¿Ya tienes cuenta? Inicia sesión</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html> 