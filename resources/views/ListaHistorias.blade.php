<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Historias</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #eef2f3, #8e9eab);
            min-height: 100vh;
            font-family: 'Segoe UI', sans-serif;
        }

        .banner {
            background-color:rgb(106, 135, 180);
            color: white;
            padding: 30px 20px;
            text-align: center;
            border-radius: 0 0 20px 20px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .banner h1 {
            margin: 0;
            font-size: 2.5rem;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            margin-top: -40px;
            background-color: #ffffffee;
        }

        .table thead {
            background-color: #f1f3f5;
        }

        .btn-custom {
            background-color:rgb(104, 153, 226);
            color: white;
            transition: all 0.3s ease-in-out;
        }

        .btn-custom:hover {
            background-color: #084298;
            color: #fff;
        }

        .empty-message {
            text-align: center;
            padding: 3rem;
            color: #6c757d;
            font-size: 1.25rem;
        }
    </style>
</head>
<body>

<div class="banner">
    <h1>📚 Mis Historias Asignadas</h1>
    <p class="lead">Revisa las historias que tienes a tu cargo</p>
</div>

<div class="container mt-4">
    <div class="card p-4">
        @if($historias->isEmpty())
            <div class="empty-message">
                <p>😴 Aún no tienes historias asignadas. ¡Hora de crear algo increíble!</p>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover align-middle text-center">
                    <thead>
                        <tr>
                            <th>📝 Nombre</th>
                            <th>👤 Responsable</th>
                            <th>🚀 Sprint</th>
                            <th>📅 Fecha de creación</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($historias as $historia)
                            <tr>
                                <td><strong>{{ $historia->nombre }}</strong></td>
                                <td>{{ $historia->responsable }}</td>
                                <td>{{ $historia->sprint }}</td>
                                <td>{{ $historia->created_at->format('d/m/Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
        <div class="text-end mt-4">
            <a href="{{ route('tablero') }}" class="btn btn-custom"><i class="bi bi-arrow-left-circle"></i> Volver al Tablero</a>
        </div>
    </div>
</div>

<!-- Bootstrap Icons (opcional, para íconos más pro) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

</body>
</html>