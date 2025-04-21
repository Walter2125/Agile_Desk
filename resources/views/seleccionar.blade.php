<!DOCTYPE html>
<html>
<head>
    <title>Seleccionar Historia para Archivar</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }

        .container {
            max-width: 700px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 0 12px rgba(0,0,0,0.15);
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
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

        button {
            padding: 8px 14px;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            color: white;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        a.back {
            display: inline-block;
            margin-top: 15px;
            color: #007bff;
            text-decoration: none;
        }

        a.back:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Selecciona una Historia para Archivar</h2>

        <ul>
            @foreach($historias as $historia)
                <li>
                    <strong>{{ $historia->nombre }}</strong>
                    <form method="POST" action="{{ route('archivo.archivar', $historia->id) }}">
                        @csrf
                        <button type="submit">Archivar</button>
                    </form>
                </li>
            @endforeach
        </ul>

        <a href="{{ route('tablero') }}" class="back">← Volver al Tablero</a>
    </div>
</body>
</html>