@extends('adminlte::page')

@section('title', 'Agile Desk')

@section('content_header')
    <h1>Seleccionar Historia para Archivar</h1>
@stop

@section('adminlte_css')
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('ccs/style.css') }}">
    <style>
        body {
            background-color: rgb(135, 168, 224);
        }

        .container-box {
            max-width: 700px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 0 12px rgba(0,0,0,0.15);
        }

        ul {
            list-style: none;
            padding: 0;
        }

        li {
            background-color: #e9ecef;
            margin: 10px 0;
            padding: 15px 20px;
            border-radius: 5px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .archive-button {
            padding: 8px 14px;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            color: white;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .archive-button:hover {
            background-color: #0056b3;
        }

        .back-link {
            display: inline-block;
            margin-top: 15px;
            color: #007bff;
            text-decoration: none;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
@stop

@section('content')
    <div class="container-box">
        <h2 class="text-center mb-4">Selecciona una Historia para Archivar</h2>

        @if(count($historias) > 0)
            <ul>
                @foreach($historias as $historia)
                    <li>
                        <strong>{{ $historia->nombre }}</strong>
                        <form method="POST" action="{{ route('archivo.archivar', $historia->id) }}">
                            @csrf
                            <button type="submit" class="archive-button">Archivar</button>
                        </form>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-center text-danger">No hay historias disponibles para archivar.</p>
        @endif

        <a href="{{ route('tablero') }}" class="back-link">← Volver al Tablero</a>
    </div>
@stop