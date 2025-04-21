<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Error</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4f46e5;
            --secondary-color: #6366f1;
            --text-color: #4b5563;
            --light-text: #9ca3af;
            --background: #f9fafb;
            --card-bg: #ffffff;
            --shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--background);
            color: var(--text-color);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 1rem;
            overflow: hidden;
        }

        .error-container {
            width: 100%;
            max-width: 1000px;
            background-color: var(--card-bg);
            border-radius: 16px;
            box-shadow: var(--shadow);
            overflow: hidden;
            position: relative;
        }

        .error-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 1.5rem;
            max-height: 100vh;
        }

        .error-message {
            flex: 1;
            padding: 1rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            justify-content: center;
            position: relative;
            z-index: 2;
        }

        .error-code {
            font-size: 3.5rem;
            font-weight: 800;
            color: var(--primary-color);
            line-height: 1;
            margin-bottom: 1rem;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            position: relative;
        }

        .error-code::after {
            content: "";
            position: absolute;
            height: 4px;
            width: 60px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            bottom: -0.5rem;
            left: 50%;
            transform: translateX(-50%);
            border-radius: 2px;
        }

        .error-text {
            font-size: 1.25rem;
            color: var(--text-color);
            margin-bottom: 1.5rem;
            font-weight: 500;
        }

        .btn-home {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            font-size: 1rem;
            font-weight: 600;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .btn-home:hover {
            transform: translateY(-3px);
            box-shadow: 0 7px 14px rgba(50, 50, 93, 0.1), 0 3px 6px rgba(0, 0, 0, 0.08);
        }

        .btn-home i {
            margin-right: 0.5rem;
        }

        .error-animation {
            display: none; /* Oculto por defecto en móviles */
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .error-image {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 2rem;
            width: 100%;
            height: auto;
            max-width: 500px; /* Límite máximo opcional (ajusta según necesidad) */
            margin: 0 auto;
        }

        .error-image img {
            width: 80%; /* Ancho natural de la imagen */
            height: 100%; /* Altura proporcional */
            border-radius: 12px;
            transition: transform 0.3s ease;
        }

        .background-decoration {
            position: absolute;
            width: 200px;
            height: 200px;
            border-radius: 50%;
            background: linear-gradient(135deg, rgba(79, 70, 229, 0.1), rgba(99, 102, 241, 0.1));
            top: -100px;
            right: -100px;
            z-index: 1;
        }

        .background-decoration:nth-child(2) {
            left: -100px;
            bottom: -100px;
            top: auto;
            right: auto;
        }

        /* Media queries específicas para diferentes tamaños de pantalla */
        /* Móviles pequeños */
        @media (max-width: 375px) {
            .error-code {
                font-size: 2.8rem;
            }
            
            .error-text {
                font-size: 1rem;
            }
            
            .error-content {
                padding: 1rem;
            }
            
            .error-message {
                padding: 0.5rem;
            }
            
            .btn-home {
                padding: 0.6rem 1.2rem;
                font-size: 0.9rem;
            }
        }

        /* Móviles medianos */
        @media (min-width: 376px) and (max-width: 576px) {
            .error-code {
                font-size: 3rem;
            }
            
            .error-image img {
                max-height: 25vh;
            }
        }

        /* Tablets */
        @media (min-width: 577px) and (max-width: 767px) {
            .error-content {
                padding: 1.5rem;
            }
        }

        /* Pantallas medianas y grandes */
        @media (min-width: 768px) {
            .error-content {
                flex-direction: row;
                align-items: stretch;
                padding: 2rem;
            }

            .error-message {
                text-align: left;
                align-items: flex-start;
                padding: 2rem;
            }

            .error-code {
                font-size: 4.5rem;
            }

            .error-code::after {
                left: 0;
                transform: none;
            }

            .error-text {
                font-size: 1.5rem;
            }

            .error-animation {
                display: block; /* Mostrar en pantallas más grandes */
                width: 220px;
                margin-top: 1.5rem;
            }
            
            .error-image img {
                max-height: 40vh;
            }
        }

        /* Pantallas muy grandes */
        @media (min-width: 1200px) {
            .error-code {
                font-size: 5rem;
            }
            
            .error-animation {
                width: 280px; /* Más grande en pantallas muy grandes */
            }
            
            .error-image img {
                max-height: 50vh;
            }
        }
    </style>
</head>

<body>
    <div class="error-container">
        <div class="background-decoration"></div>
        <div class="background-decoration"></div>

        <div class="error-content">
            <div class="error-message">
                <div class="error-code">@yield('code')</div>
                <div class="error-text">@yield('message')</div>
                <a href="/login" class="btn-home">
                    <i class="fas fa-home"></i> Volver a Home
                </a>
                <div class="error-animation">
                    <img src="{{ asset('gif/gato.gif') }}" alt="Animación de error" width="100%">
                </div>
            </div>
            <div class="error-image">
                <img src="{{ asset('img/errores/escritorio.png') }}" alt="Ilustración de error">
            </div>
        </div>
    </div>