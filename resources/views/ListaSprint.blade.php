<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Sprints</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(to right, #1E3C72, #2A5298);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0px 4px 25px rgba(0, 0, 0, 0.3);
            width: 90%;
            max-width: 900px;
            text-align: center;
        }

        h2 {
            color: #1E88E5;
            margin-bottom: 20px;
            font-size: 28px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .filters {
            margin-bottom: 20px;
        }

        select {
            padding: 10px;
            border-radius: 8px;
            border: none;
            background: #1E88E5;
            color: white;
            font-size: 16px;
            cursor: pointer;
            outline: none;
            transition: background 0.3s;
        }

        select:hover {
            background: #1565C0;
        }

        ul {
            list-style: none;
            padding: 0;
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        .sprint {
            background: #ffffff;
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
        }

        .sprint:hover {
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

        @media (max-width: 600px) {
            ul {
                flex-direction: column;
                align-items: center;
            }
            .sprint {
                width: 90%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>📌 Lista de Sprints</h2>
        <div class="filters">
            <label for="sort">Ordenar por:</label>
            <select id="sort">
                <option value="fecha_inicio">Fecha de inicio</option>
                <option value="fecha_fin">Fecha de fin</option>
            </select>
        </div>
        <ul id="sprint-list">
            @foreach ($sprints as $sprint)
                <li class="sprint" data-start="{{ $sprint->fecha_inicio }}" data-end="{{ $sprint->fecha_fin }}">
                    <h3>🚀 {{ $sprint->nombre }}</h3>
                    <p>📅 Inicio: <span>{{ $sprint->fecha_inicio }}</span></p>
                    <p>⏳ Fin: <span>{{ $sprint->fecha_fin }}</span></p>
                    <p class="status {{ str_replace(' ', '_', $sprint->estado) }}">🔵 {{ ucfirst(strtolower($sprint->estado)) }}</p>
                </li>
            @endforeach
        </ul>
    </div>
    <script>
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
    </script>
</body>
</html>