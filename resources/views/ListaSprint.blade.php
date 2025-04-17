@extends('adminlte::page')

@section('title', 'Agile Desk')

@section('adminlte_css')
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('style.css') }}"> 
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(to right, #1E3C72, #2A5298);
            margin: 0;
            padding: 20px;
            min-height: 100vh;
        }

        .content-wrapper {
            width: 100%;
        }

        h2 {
            color: white;
            text-align: left;
            font-size: 24px;
            font-weight: 600;
            text-transform: uppercase;
            margin-bottom: 20px;
        }

        .filters {
            text-align: center;
            margin-bottom: 20px;
        }

        select {
            padding: 10px;
            border-radius: 8px;
            border: none;
            background: rgb(38, 135, 225);
            color: white;
            font-size: 16px;
            cursor: pointer;
            outline: none;
            transition: background 0.3s;
        }

        select:hover {
            background: rgb(153, 193, 239);
        }

        #sprint-list {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        .sprint-item {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
            border-left: 6px solid #42A5F5;
            flex: 1 1 250px;
            max-width: 300px;
            min-width: 220px;
            text-align: left;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            position: relative;
            overflow: hidden;
            cursor: pointer;
        }

        .sprint-item:hover {
            transform: translateY(-5px);
            box-shadow: 0px 8px 25px rgba(0, 0, 0, 0.3);
        }

        .status {
            font-weight: bold;
            font-size: 14px;
            padding: 6px 12px;
            border-radius: 5px;
            display: inline-block;
        }

        .PLANEADO { background: #FF9800; color: white; }
        .EN_CURSO { background: #4CAF50; color: white; }
        .FINALIZADO { background: #E53935; color: white; }
    </style>
@stop

@section('content')
    <h2>Lista de Sprints</h2>
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
    <script src="{{ asset('js/color.js') }}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById('sort').addEventListener('change', function() {
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
                sprint.addEventListener("click", function() {
                    let sprintId = this.dataset.id;
                    let url = `/tablero/${sprintId}`;
                    window.location.href = url;
                });
            });
        });
    </script>
@stop
