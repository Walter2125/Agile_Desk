@extends('adminlte::page')

@section('title', 'Detalles de Sprints')

@section('content_header')
    <h1>Detalles de Sprints</h1>
@stop

@section('adminlte_css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('style.css') }}">
    <style>
        body {
            background-color: rgb(135, 168, 224);
        }
        .sprint-item {
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
            background-color: rgba(255, 255, 255, 0.9);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .sprint-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        .status-activo { color: #3498db; }
        .status-completado { color: #2ecc71; }
        .status-pendiente { color: #f39c12; }
        .details-button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 8px 15px;
            cursor: pointer;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }
        .details-button:hover {
            background-color: #0056b3;
        }
    </style>
@stop

@section('content')

    @if(isset($sprints) && count($sprints) > 0)
        <div id="sprint-list" class="container">
            @foreach($sprints as $sprint)
                <div class="sprint-item">
                    <div class="sprint-title" style="font-size: 20px; font-weight: bold; color: #34495e;">
                        {{ $sprint->nombre }}
                    </div>
                    <div><strong>Inicio:</strong> {{ $sprint->fecha_inicio }}</div>
                    <div><strong>Fin:</strong> {{ $sprint->fecha_fin }}</div>
                    @php
                        $statusClass = ($sprint->estado === 'EN CURSO') ? 'status-activo' :
                                       (($sprint->estado === 'FINALIZADO') ? 'status-completado' : 'status-pendiente');
                    @endphp
                    <div class="sprint-status {{ $statusClass }}">
                        <strong>Estado:</strong> {{ $sprint->estado }}
                    </div>
                    <button class="details-button" onclick="showDetails('{{ $sprint->nombre }}', 'Responsable: {{ $sprint->responsable }}')">Detalles</button>
                    
                    <h3>Historias:</h3>
                    @foreach($sprint->historias as $historia)
                        <p><strong>{{ $historia->nombre }}</strong></p>
                        <h4>Tareas:</h4>
                        @foreach($historia->tareas as $tarea)
                            <p>- {{ $tarea->nombre }}</p>
                        @endforeach
                    @endforeach
                </div>
            @endforeach
        </div>
    @else
        <p class="text-center text-danger">No hay sprints disponibles</p>
    @endif
@stop

@section('adminlte_js')
    <script>
        function showDetails(title, body) {
            alert(title + "\n" + body);
        }
    </script>
@stop
