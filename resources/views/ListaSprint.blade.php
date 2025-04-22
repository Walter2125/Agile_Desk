@extends('adminlte::page')

@section('title', 'Agile Desk')

@section('adminlte_css')
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('style.css') }}">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(120deg, #1E3C72, #2A5298);
            margin: 0;
            padding: 0;
            min-height: 100vh;
        }

        .wrapper, .content-wrapper, .content, .main-header, .main-footer {
            background: transparent !important;
            border: none !important;
            box-shadow: none !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        .content-wrapper {
            padding-top: 0 !important;
            margin-top: 0 !important;
        }

        h2 {
    color: #fff;
    font-size: 8vw;
    font-weight: 600;
    margin: 20px 0;
    text-align: center;
    border-left: none;
}

@media (min-width: 768px) {
    h2 {
        font-size: 32px;
    }
}
        .filters {
            text-align: center;
            margin-bottom: 30px;
            padding: 0 10px;
        }

        .filters label {
            color: white;
            font-weight: 500;
            display: block;
            margin-bottom: 8px;
        }

        .filters select {
            width: 100%;
            max-width: 280px;
            padding: 10px 15px;
            border-radius: 10px;
            border: none;
            background: #2196F3;
            color: #fff;
            font-size: 16px;
            transition: background 0.3s;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .filters select:hover {
            background: #64B5F6;
        }

        #sprint-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 25px;
            padding: 0 20px 40px;
        }

        .sprint-item {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            padding: 25px;
            border-radius: 16px;
            box-shadow: 0px 8px 24px rgba(0, 0, 0, 0.2);
            border-left: 6px solid #42A5F5;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
        }

        .sprint-item:hover {
            transform: translateY(-8px);
            box-shadow: 0px 12px 32px rgba(0, 0, 0, 0.3);
        }

        .sprint-item h3 {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 10px;
            color: #333;
        }

        .sprint-item p {
            font-size: 15px;
            margin: 6px 0;
            color: #444;
        }

        .status {
            font-weight: 600;
            font-size: 14px;
            padding: 6px 12px;
            border-radius: 6px;
            display: inline-block;
            margin-top: 10px;
        }

        .PLANEADO { background: #FFA726; color: white; }
        .EN_CURSO { background: #66BB6A; color: white; }
        .FINALIZADO { background: #EF5350; color: white; }
    </style>
@stop

@section('content')
    <h2>📋 Lista de Sprints</h2>

    <div class="filters">
        <label for="sort">Ordenar por:</label>
        <select id="sort">
            <option value="fecha_inicio">Fecha de inicio</option>
            <option value="fecha_fin">Fecha de fin</option>
        </select>
    </div>

    <div id="sprint-list">
        @foreach($sprints as $sprint)
            <div class="sprint-item" data-start="{{ $sprint->fecha_inicio }}" data-end="{{ $sprint->fecha_fin }}" data-id="{{ $sprint->id }}">
                <h3>🚀 {{ $sprint->nombre }}</h3>
                <p>📅 Inicio: <span>{{ $sprint->fecha_inicio }}</span></p>
                <p>⏳ Fin: <span>{{ $sprint->fecha_fin }}</span></p>
                <p class="status {{ str_replace(' ', '_', $sprint->estado) }}">🔵 {{ ucfirst(strtolower($sprint->estado)) }}</p>
            </div>
        @endforeach
    </div>
@stop

@section('adminlte_js')
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.getElementById('sort').addEventListener('change', function () {
                let list = document.getElementById('sprint-list');
                let sprints = Array.from(list.children);
                let sortBy = this.value;
                sprints.sort((a, b) => {
                    let dateA = new Date(a.dataset[sortBy]);
                    let dateB = new Date(b.dataset[sortBy]);
                    return dateA - dateB;
                });
                list.innerHTML = "";
                sprints.forEach(sprint => list.appendChild(sprint));
            });

            document.querySelectorAll(".sprint-item").forEach(sprint => {
                sprint.addEventListener("click", function () {
                    let sprintId = this.dataset.id;
                    window.location.href = `/tablero/${sprintId}`;
                });
            });
        });
    </script>
@stop