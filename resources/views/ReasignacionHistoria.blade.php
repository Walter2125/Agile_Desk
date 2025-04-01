@extends('adminlte::page')

@section('title', 'Agile Desk')

@section('adminlte_css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('style.css') }}">
    <style>

        /* Vista de reasignación */
        .container {
    max-width: 800px; /* Aumentar tamaño */
    padding: 40px; /* Aumentar espaciado interno */
    border-radius: 16px; /* Bordes más estilizados */
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15); /* Efecto más notorio */
}

        .container:hover {
            transform: scale(1.02);
        }

        h2 {
            color: #333;
            font-size: 28px;
            text-align: center;
            margin-bottom: 30px;
            font-weight: 600;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            font-weight: 600;
            font-size: 16px;
            margin-bottom: 8px;
            display: block;
            color: #555;
        }

        select {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            border-radius: 8px;
            border: 1px solid #ddd;
            background-color: #fafafa;
            transition: 0.3s;
        }

        select:focus {
            border-color: #007bff;
            outline: none;
            background-color: #fff;
        }

        .btn {
            background: #007bff;
            color: white;
            padding: 14px;
            border: none;
            width: 100%;
            font-size: 18px;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .btn-cancel {
            display: inline-block;
            margin-top: 15px;
            padding: 12px 20px;
            background-color:rgb(224, 80, 80);
            color: #333;
            font-size: 16px;
            border-radius: 8px;
            text-decoration: none;
            text-align: center;
            width: 100%;
            transition: background-color 0.3s;
        }

        .btn-cancel:hover {
            background-color: #ddd;
            color: #000;
        }

        .message {
            text-align: center;
            margin-bottom: 20px;
            font-weight: bold;
            color: #28a745;
        }

        /* Media Queries for Responsiveness */
        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }

            h2 {
                font-size: 24px;
            }

            .btn, .btn-cancel {
                padding: 12px;
                font-size: 16px;
            }
        }
    </style>
@stop

@section('content')
    <div class="container text-center mt-5">
        <h2>Reasignar Historia</h2>

        <!-- Mostrar el mensaje de éxito si está disponible -->
        @if (session('success'))
            <div class="message">{{ session('success') }}</div>
        @endif

        <!-- Formulario de reasignación -->
        <form action="{{ url('/reasignacion-historias/reasignar') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="historiaId">Seleccionar Historia</label>
                <select name="historiaId" id="historiaId" required>
                    <option value="">Seleccione una historia</option>
                    @foreach($historias as $historia)
                        <option value="{{ $historia->id }}">
                            {{ $historia->nombre }} (Responsable: {{ $historia->responsable ?? 'No asignado' }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="nuevoResponsableId">Nuevo Responsable</label>
                <select name="nuevoResponsableId" id="nuevoResponsableId" required>
                    <option value="">Seleccione un usuario</option>
                    @foreach($usuarios as $usuario)
                        <option value="{{ $usuario->id }}">{{ $usuario->name }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn">Guardar Cambios</button>
        </form>

        <!-- Botón Cancelar -->
        <a href="{{ route('homeadmin') }}" class="btn-cancel">Cancelar</a>
    </div>
@stop

@section('adminlte_js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('color.js') }}"></script>
@stop