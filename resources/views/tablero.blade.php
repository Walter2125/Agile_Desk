@extends('adminlte::page')

@section('title', 'Agile Desk')

@section('adminlte_css')


    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">

    <link rel="stylesheet" href="{{ asset('style.css') }}">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    
    @stop

@section('content')
            @if(session('fromCreate') || session('fromEdit'))
                <script>
                    window.history.pushState(null, "", window.location.href);
                    window.addEventListener("popstate", function () {
                        window.location.href = "{{ route('tablero') }}";
                    });
                </script>
            @endif
            
        <!--El mensage de guradado con exito -->

        @if (session('success'))
        <div class="alert alert-primary alert-dismissible fade show" role="alert">
        <strong></strong>
                {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>

        @endif

        
        <!-- -->
    <div class="bg-gray-100 " style="background-color: rgba(243, 244, 246, 0.068);">
        <!-- <div class="w-full mx-auto bg-white p-6 rounded-lg shadow-lg overflow-x-auto h-screen"> -->
            <h2 class="text-2xl font-bold mb-6">Tablero del proyecto {{ $tablero->project->name }}</h2>

      <!-- Barra de búsqueda y filtros -->
    <div class="flex flex-wrap items-center gap-2 mb-4">
    <!-- Input de búsqueda -->
    <input type="text" id="buscar" class="border p-2 rounded w-full sm:w-1/3" placeholder="Buscar historias o tareas...">

    <!-- Select de estado -->
    <select id="filtrarEstado" class="border p-2 rounded w-full sm:w-1/3">
        <option value="">Todos los estados</option>
        <option value="Historia">Historia</option>
        <option value="Tarea">Tarea</option>
    </select>

    <!-- Input de fecha -->
    <input type="date" id="filtrarFecha" class="border p-2 rounded w-full sm:w-1/3">

    <!-- Select de responsable -->
    <select id="filtrarResponsable" class="border p-2 rounded w-full sm:w-1/3">
        <option value="">Todos los responsables</option>
        @if (!empty($responsables))
            @foreach ($responsables as $responsable)
                <option value="{{ $responsable }}">{{ $responsable }}</option>
            @endforeach
        @endif
    </select>

    <!-- Select de etiqueta -->
    <select id="filtrarEtiqueta" class="border p-2 rounded w-full sm:w-1/3">
        <option value="">Todas las etiquetas</option>
    </select>

    <!-- Botón limpiar filtros más pequeño -->
    <button id="limpiarFiltros" class="bg-red-500 text-white px-4 py-2 rounded w-auto sm:w-24">Limpiar</button>

    <!-- Después del div de filtros, agregar este botón -->
    <button id="crearSprint" class="bg-red-500 text-white px-4 py-2 rounded w-auto sm:w-24" onclick="window.location.href='{{ route('sprints.create', ['project_id' => $tablero->project_id]) }}'">
        <i class="fas fa-plus"></i> Crear Sprint
    </button>

    <a href="{{ route('archivo.seleccionar', ['project' => $tablero->project->id]) }}" class="btn btn-warning">📦 Archivar Historia</a>
    <a href="{{ route('archivo.index.proyecto', ['project' => $tablero->project->id]) }}" class="btn">Ver Archivadas</a>
            </a>
    <a href="{{ route('proyectos.historialcambios.index', ['project' => $tablero->project->id]) }}" class="btn btn-info">
    Ver historial de cambios
</a>
<a href="{{ route('reasignar.index', ['project' => $tablero->project->id]) }}" class="btn btn-info">
    Reasignar historias
</a>

    
</div>


        </div>
    </div>
</div>
            <div id="tablero" class="kanban-board">
                <div class="kanban-column">
                    <div class="column-header">Backlog</div>
                    <div class="sortable">

                        @forelse ($tablero->historias->where('sprint_id', null)->where('estado', 'Pendiente') as $historia)
                            <a href="{{ route('formulario.show', $historia->id) }}" class="block no-underline">
                                <div class="card">
                                    <div class="flex justify-between items-start mb-1">
                                        <div class="font-bold text-lg text-black truncate max-w-[80%]" title="{{ $historia->nombre }}">
                                            {{ $historia->nombre }}
                                            
                                        </div>
                                        <div class="card-options relative">
                                            <button type="button" class="dropdown-toggle absolute right-0 top-0 bg-white border rounded shadow-sm h-6 w-6 text-xs flex items-center justify-center" data-bs-toggle="dropdown" aria-expanded="false">
                                                ...
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="{{ route('formulario.edit', $historia->id) }}"><i class="bi bi-pencil mr-2"></i>Editar</a></li>
                                                <li><button type="button" class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal-{{ $historia->id }}"><i class="bi bi-trash mr-2"></i>Eliminar</button></li>
                                            </ul>
                                            <div class="modal fade" id="confirmDeleteModal-{{ $historia->id }}" tabindex="-1" aria-labelledby="modalLabel-{{ $historia->id }}" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="modalLabel-{{ $historia->id }}">Confirmar Eliminación</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            ¿Estás seguro de que deseas eliminar este registro?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                            <form action="{{ route('formulario.destroy', $historia->id) }}" method="post">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger">Eliminar</button>
                                                            </form>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-sm text-gray-600">
                                        ID: <span class="font-semibold">{{ $historia->id }}</span><br>
                                        Prioridad: <span class="font-semibold">{{ $historia->prioridad }}</span>
                                    </div>
                                </div>
                            </a>
                        @empty

                            <p class="text-gray-500 italic">No hay historias en Backlog.</p>
                        @endforelse
                    </div>
                    <button class="create-button" onclick="window.location.href='{{ route('formulario.create', $tablero->id) }}'">+ Crear Historia</button>
                </div>
                 <!-- Columnas de Sprint -->
                @foreach($sprints as $sprint)
                <div class="kanban-column">
                    <div class="column-header" style="background-color: {{ $sprint->color }}">
                        <div class="flex justify-between items-center">
                            <div>
                                {{ $sprint->nombre }}
                                <small class="block text-xs">
                                    {{ \Carbon\Carbon::parse($sprint->fecha_inicio)->format('d/m/Y') }} - 
                                    {{ \Carbon\Carbon::parse($sprint->fecha_fin)->format('d/m/Y') }}
                                </small>
                            </div>
                            <div class="sprint-options">
                                <button type="button" class="btn btn-sm btn-info" onclick="window.location.href='{{ route('sprints.show', $sprint->id) }}'">
                                    <i class="bi bi-eye"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-light" onclick="window.location.href='{{ route('sprints.edit', $sprint->id) }}'">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteSprintModal-{{ $sprint->id }}">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Modal para eliminar sprint -->
                    <div class="modal fade" id="deleteSprintModal-{{ $sprint->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Confirmar Eliminación</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    ¿Estás seguro de que deseas eliminar el sprint "{{ $sprint->nombre }}"?
                                    Esta acción también eliminará todas las historias asociadas.
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                    <form action="{{ route('sprints.destroy', $sprint->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Eliminar Sprint</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="sortable">
                        @forelse ($tablero->historias->where('sprint_id', $sprint->id) as $historia)
                            <a href="{{ route('formulario.show', $historia->id) }}" class="block no-underline">
                                <div class="card" data-id="{{ $historia->id }}">
                                    <div class="flex justify-between items-start mb-1">
                                        <div class="font-bold text-lg text-black truncate max-w-[80%]" title="{{ $historia->nombre }}">
                                            {{ $historia->nombre }}
                                        </div>
                                        <div class="card-options relative">
                                            <button type="button" class="dropdown-toggle absolute right-0 top-0 bg-white border rounded shadow-sm h-6 w-6 text-xs flex items-center justify-center" data-bs-toggle="dropdown" aria-expanded="false">
                                                ...
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="{{ route('formulario.edit', $historia->id) }}"><i class="bi bi-pencil mr-2"></i>Editar</a></li>
                                                <li><button type="button" class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal-{{ $historia->id }}"><i class="bi bi-trash mr-2"></i>Eliminar</button></li>
                                            </ul>
                                            <div class="modal fade" id="confirmDeleteModal-{{ $historia->id }}" tabindex="-1" aria-labelledby="modalLabel-{{ $historia->id }}" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="modalLabel-{{ $historia->id }}">Confirmar Eliminación</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            ¿Estás seguro de que deseas eliminar este registro?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                            <form action="{{ route('formulario.destroy', $historia->id) }}" method="post">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger">Eliminar</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                    <div class="text-sm text-gray-600">
                                        ID: <span class="font-semibold">{{ $historia->id }}</span><br>
                                        Prioridad: <span class="font-semibold">{{ $historia->prioridad }}</span>
                                    </div>
                                    <div class="text-sm text-gray-600">
                                        ID: <span class="font-semibold">{{ $historia->id }}</span><br>
                                        Prioridad: <span class="font-semibold">{{ $historia->prioridad }}</span>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <p class="text-gray-500 italic">No hay historias en este sprint.</p>
                        @endforelse
                    </div>
                    <button class="create-button" onclick="window.location.href='{{ route('formulario.create', ['tablero' => $tablero->id, 'sprint' => $sprint->id]) }}'">
                        + Crear Historia
                    </button>

                </div>
                @endforeach
            </div>
            <!-- Botón para crear nuevo sprint -->
            <button class="add-column-button" onclick="window.location.href='{{ route('sprints.create', ['project_id' => $tablero->project_id]) }}'">
                <i class="fas fa-plus"></i>
            </button>
        </div>
    </div>
</div>

<!-- modal-->
<div id="miModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white p-5 rounded shadow-lg w-1/3">
        <h2 class="text-xl font-bold mb-4">Agregar Tarea</h2>
        <div id="listaTareas"></div>
        <button class="btn btn-success mt-2" onclick="agregarTarea()">Agregar Tarea</button>
        <button class="btn btn-danger mt-2" onclick="cerrarModal()">Cerrar</button>
    </div>
</div>

<script>
    function abrirModal(id) {
        document.getElementById("miModal").style.display = "flex";
    }

    function cerrarModal() {
        document.getElementById("miModal").style.display = "none";
    }

    function agregarTarea() {
        let lista = document.getElementById("listaTareas");
        let nuevaTarea = document.createElement("div");
        nuevaTarea.className = "tarea-item";
        nuevaTarea.innerHTML = <input type="text" placeholder="Descripción de la tarea">;
        lista.appendChild(nuevaTarea);
    }
</script>

<!-- Modal -->
<div id="modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h3 class="text-xl font-bold mb-4">Editar Nombre de Columna</h3>
        <input type="text" id="nuevoNombre" class="border p-2 w-full mb-4">
        <div class="flex justify-end space-x-2">
            <button id="cancelar" class="bg-red-500 text-white px-4 py-2 rounded">Cancelar</button>
            <button id="guardar" class="bg-green-500 text-white px-4 py-2 rounded">Guardar</button>
        </div>
    </div>
</div>


<!-- Modal para etiquetas -->
<div id="modalEtiquetas" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-96">
        <h3 class="text-xl font-bold mb-4">Asignar Etiquetas</h3>
        <div id="listaEtiquetas" class="mb-4 space-y-2"></div>
        <div class="flex justify-end space-x-2">
            <button id="cerrarEtiquetas" class="bg-red-500 text-white px-4 py-2 rounded">Cancelar</button>
            <button id="guardarEtiquetas" class="bg-green-500 text-white px-4 py-2 rounded">Guardar</button>
        </div>
    </div>

</div>



@stop

@section('adminlte_js')
    <!-- Bootstrap Bundle JS -->
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <!-- Sortable JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <!--Script personalizado para manejo del tema -->
    <script src="{{ asset('js/color.js') }}"></script>
    <!-- Código del Tablero Scrum -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tablero = document.getElementById('tablero');
            const modal = document.getElementById('modal');
            const nuevoNombreInput = document.getElementById('nuevoNombre');
            let columnaActual;

            document.getElementById('agregarColumna').addEventListener('click', agregarColumna);

            function agregarColumna() {
                if (document.querySelectorAll('.columna').length >= 9) return;
                const nuevaColumna = document.createElement('div');
                nuevaColumna.classList.add('columna', 'bg-gray-200', 'p-4', 'rounded', 'w-60', 'flex-shrink-0');
                nuevaColumna.innerHTML = `
                    <div class="flex justify-between items-center">
                        <span class="titulo-columna text-lg font-bold" >Nueva columna</span>
                        <div class="relative">
                        <div class="btn-group dropend">
                                <!-- Botón del Dropdown -->
                                <button type="button" class="btn btn-secondary dropdown-toggle   absolute right-0 top-6 bg-white border rounded shadow-lg " data-bs-toggle="dropdown" aria-expanded="false" style="position: relative; top: -2px; height: 28px; width: 28px; font-size: 14px; padding: 4px;">
                                </button>

                                <!-- Contenido del Dropdown -->
                                <ul class="dropdown-menu">
                                    <!-- Opción: Crear Historia -->
                                    <li>
                                        <a class="dropdown-item" href="{{ route('formulario.create', $tablero->id) }}">
                                            <i class="bi bi-plus"></i> Crear Historia
                                        </a>
                                    </li>
                                    <!-- Opción: Editar Nombre de la Columna -->
                                    <li>
                                        <button class="dropdown-item editar-columna">
                                            Editar Nombre de la Columna
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                `;
                tablero.appendChild(nuevaColumna);
                inicializarArrastrables();
                agregarEventosOpciones();
            }

            function agregarEventosOpciones() {
                document.querySelectorAll('.opciones-columna').forEach(btn => {
                    btn.addEventListener('click', () => {
                        const menu = btn.nextElementSibling;
                        document.querySelectorAll('.menu-opciones').forEach(m => m.classList.add('hidden'));
                        menu.classList.toggle('hidden');
                    });
                });

                document.addEventListener('click', (e) => {
                    if (!e.target.classList.contains('opciones-columna')) {
                        document.querySelectorAll('.menu-opciones').forEach(m => m.classList.add('hidden'));
                    }
                });

                document.querySelectorAll('.eliminar-columna').forEach(btn => {
                    btn.addEventListener('click', () => {
                        const columna = btn.closest('.columna');
                        columna.remove();
                    });
                });

                document.querySelectorAll('.agregar-tarea').forEach(btn => {
                    btn.addEventListener('click', () => {
                        window.location.href = '/form';
                    });
                });
            }

            function inicializarArrastrables() {
                document.querySelectorAll('.sortable').forEach(el => {
                    new Sortable(el, {
                        group: 'scrum',
                        animation: 150,
                        //nuevo codigo
                        onEnd(evt) {
                            const tarjeta = evt.item; // Tarjeta movida
                            const columnaDestino = evt.to.closest('.columna'); // Columna destino
                            const nuevoEstado = columnaDestino.querySelector('.titulo-columna').textContent.trim(); // Nombre de la columna
                            const historiaId = tarjeta.dataset.id; // ID de la historia

                            // Enviar la actualización al servidor
                            fetch('/actualizar-estado', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                },
                                body: JSON.stringify({ id: historiaId, estado: nuevoEstado })
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    toastr.success(El estado de la historia ha cambiado a:
                document.querySelectorAll('.eliminar-columna').forEach(btn => {0 top-6 bg-white border rounded shadow-lg z-10">
                    btn.addEventListener('click', () => {umna px-4 py-2 hover:bg-gray-100 w-full text-left">Editar Nombre</button>
                        const columna = btn.closest('.columna');                                <button class="eliminar-columna px-4 py-2 hover:bg-gray-100 w-full text-left">Eliminar Columna</button>
                        columna.remove();
                    }); </div>
                }); </div>
                    <div class="min-h-[150px] space-y-2 sortable"></div>
                document.querySelectorAll('.agregar-tarea').forEach(btn => {                `;
                    btn.addEventListener('click', () => {   tablero.appendChild(nuevaColumna);
                inicializarArrastrables();
                        window.location.href = '/form';
                    });
                });
ones() {
ll('.opciones-columna').forEach(btn => {
            }er('click', () => {
 btn.nextElementSibling;
            function inicializarArrastrables() {Each(m => m.classList.add('hidden'));
                document.querySelectorAll('.sortable').forEach(el => {
                    new Sortable(el, {
                        group: 'scrum',
                        animation: 150,
                        //nuevo codigo
                        onEnd(evt) {iones-columna')) {
                            const tarjeta = evt.item; // Tarjeta movidall('.menu-opciones').forEach(m => m.classList.add('hidden'));
                            const columnaDestino = evt.to.closest('.columna'); // Columna destino
                            const nuevoEstado = columnaDestino.querySelector('.titulo-columna').textContent.trim(); // Nombre de la columna
                            const historiaId = tarjeta.dataset.id; // ID de la historia

                            // Enviar la actualización al servidor
                            fetch('/actualizar-estado', {ntListener('click', () => {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                },
                                body: JSON.stringify({ id: historiaId, estado: nuevoEstado })
                            })ner('click', () => {
                                .then(response => response.json())
                                .then(data => {form';
                                    if (data.success) {
                                        toastr.success(El estado de la historia ha cambiado a: ${nuevoEstado}.);
                                    } else {
                                        toastr.error('Error al actualizar el estado.');
                                    }            }
                                })
                                .catch(error => {n inicializarArrastrables() {
                                    console.error('Error:', error);   document.querySelectorAll('.sortable').forEach(el => {
                                    toastr.error('No se pudo conectar con el servidor.');                    new Sortable(el, {
                                });,
                        }0,
             //nuevo codigo
                    });           onEnd(evt) {
                });                            const tarjeta = evt.item; // Tarjeta movida
            }                    const columnaDestino = evt.to.closest('.columna'); // Columna destino
o.querySelector('.titulo-columna').textContent.trim(); // Nombre de la columna
            inicializarArrastrables(); // ID de la historia
            agregarEventosOpciones();
        });
    });

    function abrirModal(card) {
        tarjetaSeleccionada = card;
        modalEtiquetas.classList.remove('hidden');
        generarOpcionesEtiquetas(card);
    }

    function generarOpcionesEtiquetas(card) {
        listaEtiquetas.innerHTML = "";
        etiquetasDisponibles.forEach(etiqueta => {
            const div = document.createElement('div');
            div.classList.add('flex', 'items-center', 'space-x-2');

            const radio = document.createElement('input');
            radio.type = 'radio';
            radio.name = 'etiquetaSeleccionada';
            radio.value = etiqueta.nombre;
            radio.checked = card.dataset.etiquetas === etiqueta.nombre || (etiqueta.nombre === "Sin etiqueta" && !card.dataset.etiquetas);

            const label = document.createElement('span');
            label.textContent = etiqueta.nombre;
            label.classList.add('px-2', 'py-1', 'rounded', etiqueta.color, 'text-white');

            div.appendChild(radio);
            div.appendChild(label);
            listaEtiquetas.appendChild(div);
        });
    }

    guardarEtiquetas.addEventListener('click', () => {
        if (!tarjetaSeleccionada) return;
        const etiquetaSeleccionada = listaEtiquetas.querySelector('input[name="etiquetaSeleccionada"]:checked').value;
        tarjetaSeleccionada.dataset.etiquetas = etiquetaSeleccionada;
        mostrarEtiquetasEnTarea(tarjetaSeleccionada, etiquetaSeleccionada);
        const idTarea = tarjetaSeleccionada.dataset.id;
        localStorage.setItem(etiqueta_${idTarea}, etiquetaSeleccionada);
        if (etiquetaSeleccionada === "Urgente") {
            toastr.warning("Tarea marcada como Urgente. Notificando al líder técnico...");
        }
        modalEtiquetas.classList.add('hidden');
        tarjetaSeleccionada = null;
    });

    cerrarEtiquetas.addEventListener('click', () => {
        modalEtiquetas.classList.add('hidden');
        tarjetaSeleccionada = null;
    });

    function mostrarEtiquetasEnTarea(card, etiqueta) {
        let etiquetaContainer = card.querySelector('.etiquetas');
        if (!etiquetaContainer) {
            etiquetaContainer = document.createElement('div');
            etiquetaContainer.classList.add('flex', 'space-x-1', 'mt-2', 'etiquetas');
            card.appendChild(etiquetaContainer);
        }
        etiquetaContainer.innerHTML = "";
        if (etiqueta !== "Sin etiqueta") {
            const etiquetaData = etiquetasDisponibles.find(e => e.nombre === etiqueta);
            const etiquetaSpan = document.createElement('span');
            etiquetaSpan.textContent = etiqueta;
            etiquetaSpan.classList.add('px-2', 'py-1', 'text-white', 'rounded', etiquetaData.color);
            etiquetaContainer.appendChild(etiquetaSpan);
        }
    }
    
    </script>
@stop

<style>
    .kanban-board {
        display: flex;
        align-items: flex-start;
        overflow-x: auto;
        gap: 1rem;
        padding: 1rem;
        min-height: 70vh;
    }

    .kanban-column {
        background-color: #f3f4f6;
        border-radius: 0.5rem;
        width: 300px;
        min-width: 300px;
        margin: 0 0.5rem;
        padding: 1rem;
        display: flex;
        flex-direction: column;
    }

    .column-header {
        font-weight: bold;
        padding: 0.75rem;
        border-radius: 0.375rem;
        margin-bottom: 1rem;
        text-align: center;
        background-color: #e5e7eb;
    }

    .sortable {
        flex-grow: 1;
        min-height: 100px;
    }

    .card {
        background-color: white;
        padding: 0.75rem;
        margin-bottom: 0.75rem;
        border-radius: 0.375rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .sprint-options {
        display: flex;
        gap: 0.5rem;
    }

    .sprint-options button {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
    }
</style>