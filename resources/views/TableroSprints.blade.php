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

        <!-- migajas de pan-->
        <div class="container py-3 migajas" id="migajas">
            <ul class="breadcrumb">
                <li class="breadcrumb__item breadcrumb__item-firstChild">
                    <span class="breadcrumb__inner">
                        <a href="/HomeUser" class="breadcrumb__title">Home</a>
                    </span>
                </li>
                <li class="breadcrumb__item breadcrumb__item-firstChild">
                    <span class="breadcrumb__inner">
                        <a href="/projects" class="breadcrumb__title">Proyectos</a>
                    </span>
                </li>
                <li class="breadcrumb__item breadcrumb__item--active">
                    <span class="breadcrumb__inner">
                        <span class="breadcrumb__title">Tableros</span>
                    </span>
                </li>
            </ul>
        </div>
        <!-- -->
    <div class="bg-gray-100 p-10" style="background-color: rgba(243, 244, 246, 0.068);">
        <!-- <div class="w-full mx-auto bg-white p-6 rounded-lg shadow-lg overflow-x-auto h-screen"> -->
            <h2 class="text-2xl font-bold mb-6">
    Tablero del proyecto {{ $tablero?->project?->name ?? 'Proyecto no encontrado' }}
</h2>

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
</div>

<a href="{{ route('archivo.seleccionar') }}" class="btn btn-warning">📦 Archivar Historia</a>
<a href="{{ route('archivo.index') }}" class="btn btn-sm btn-light me-2">
                <i class="fas fa-archive me-1"></i> Ver Archivadas
            </a>
        </div>
    </div>
</div>

            <div class="flex justify-between mb-4 items-center">


            <div id="tablero" class="kanban-board">
                <div class="kanban-column">
                    <div class="column-header">Pendiente</div>
                    <div class="sortable">
                        @forelse ($tablero->historias->where('estado', 'Pendiente') as $historia)
                            <a href="{{ route('formulario.show', $historia->id) }}" class="block no-underline">
                                <div class="card">
                                    <div class="flex justify-between items-start mb-1">
                                        <div class="font-bold text-lg text-black truncate  title="{{ $historia->nombre }}">
                                            {{ $historia->nombre }}
                                        </div>
                                    <div class="card-options flex gap-2 justify-end">
                                        <!-- Botón de editar -->
                                        <a href="{{ route('formulario.edit', $historia->id) }}" class="text-blue-600 hover:text-blue-800" title="Editar">
                                            <i class="bi bi-pencil-fill"></i>
                                        </a>

                                        <!-- Botón para abrir el modal de eliminación -->
                                        <button type="button" class="text-red-600 hover:text-red-800" title="Eliminar"
                                                data-bs-toggle="modal" data-bs-target="#confirmDeleteModal-{{ $historia->id }}">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </div>

                                    <!-- Modal de confirmación para eliminar -->
                                    <div class="modal fade" id="confirmDeleteModal-{{ $historia->id }}" tabindex="-1"
                                         aria-labelledby="modalLabel-{{ $historia->id }}" aria-hidden="true">
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
                                                    <form action="{{ route('formulario.destroy', $historia->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Eliminar</button>
                                                    </form>
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
                            <p class="text-gray-500 italic">No hay historias en esta columna.</p>
                        @endforelse
                    </div>
                    <button class="create-button" onclick="window.location.href='{{ route('formulario.create', $tablero->id) }}'">+ Crear Historia</button>
                </div>

                <div class="kanban-column">
                    <div class="column-header">En Curso</div>
                    <div class="sortable">
                        @forelse ($tablero->historias->where('estado', 'En Curso') as $historia)
                            <a href="{{ route('formulario.show', $historia->id) }}" class="block no-underline">
                                <div class="card">
                                    <div class="flex justify-between items-start mb-1">
                                        <div class="font-bold text-lg text-black truncate " title="{{ $historia->nombre }}">
                                            {{ $historia->nombre }}
                                        </div>
                                        <div class="card-options flex gap-2 justify-end">
                                            <!-- Botón de editar -->
                                            <a href="{{ route('formulario.edit', $historia->id) }}" class="text-blue-600 hover:text-blue-800" title="Editar">
                                                <i class="bi bi-pencil-fill"></i>
                                            </a>

                                            <!-- Botón para abrir el modal de eliminación -->
                                            <button type="button" class="text-red-600 hover:text-red-800" title="Eliminar"
                                                    data-bs-toggle="modal" data-bs-target="#confirmDeleteModal-{{ $historia->id }}">
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
                                        </div>

                                        <!-- Modal de confirmación para eliminar -->
                                        <div class="modal fade" id="confirmDeleteModal-{{ $historia->id }}" tabindex="-1"
                                             aria-labelledby="modalLabel-{{ $historia->id }}" aria-hidden="true">
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
                                                        <form action="{{ route('formulario.destroy', $historia->id) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">Eliminar</button>
                                                        </form>
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
                            <p class="text-gray-500 italic">No hay historias en esta columna.</p>
                        @endforelse
                    </div>
                    <button class="create-button" onclick="window.location.href='{{ route('formulario.create', $tablero->id) }}'">+ Crear Historia</button>
                </div>

                <div class="kanban-column">
                    <div class="column-header">Listo</div>
                    <div class="sortable">
                        @forelse ($tablero->historias->where('estado', 'Listo') as $historia)
                            <a href="{{ route('formulario.show', $historia->id) }}" class="block no-underline">
                                <div class="card">
                                    <div class="flex justify-between items-start mb-1">
                                        <div class="font-bold text-lg text-black truncate " title="{{ $historia->nombre }}">
                                            {{ $historia->nombre }}
                                        </div>
                                        <div class="card-options flex gap-2 justify-end">
                                            <!-- Botón de editar -->
                                            <a href="{{ route('formulario.edit', $historia->id) }}" class="text-blue-600 hover:text-blue-800" title="Editar">
                                                <i class="bi bi-pencil-fill"></i>
                                            </a>

                                            <!-- Botón para abrir el modal de eliminación -->
                                            <button type="button" class="text-red-600 hover:text-red-800" title="Eliminar"
                                                    data-bs-toggle="modal" data-bs-target="#confirmDeleteModal-{{ $historia->id }}">
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
                                        </div>

                                        <!-- Modal de confirmación para eliminar -->
                                        <div class="modal fade" id="confirmDeleteModal-{{ $historia->id }}" tabindex="-1"
                                             aria-labelledby="modalLabel-{{ $historia->id }}" aria-hidden="true">
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
                                                        <form action="{{ route('formulario.destroy', $historia->id) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">Eliminar</button>
                                                        </form>
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
                            <p class="text-gray-500 italic">No hay historias en esta columna.</p>
                        @endforelse
                    </div>
                    <button class="create-button" onclick="window.location.href='{{ route('formulario.create', $tablero->id) }}'">+ Crear Historia</button>
                </div>



                @foreach ($tablero->columnas as $columna)
                <div class="kanban-column" id="columna-{{ $columna->id }}">
                    <div class="column-header">{{ $columna->nombre }}</div>
                    <div class="sortable">
                        @foreach ($columna->historias as $historia)
                            <!-- Mostrar historias aquí -->
                        @endforeach
                    </div>
                    <button class="create-button" onclick="window.location.href='{{ route('formulario.create', ['tablero' => $tablero->id, 'columna' => $columna->id]) }}'">+ Crear Historia</button>
                </div>
            @endforeach

                </div>




                <button class="add-column-button" onclick="abrirModalAgregarColumna()">+</button>




            </div>



            <style>
                .kanban-board {
                    display: flex;
                    gap: 1rem;
                    padding: 1rem;
                    overflow-x: auto;
                    scroll-behavior: smooth;
                }

                .kanban-column {
                    flex: 1;
                    min-width: 250px;
                    max-width: 100%;
                    background-color: #f0f0f0;
                    border-radius: 5px;
                    display: flex;
                    flex-direction: column;
                    padding: 10px;
                }

                @media (min-width: 768px) {
                    .kanban-column {
                        max-width: calc(100% / 4 - 1rem);
                    }
                }

                .column-header {
                    font-weight: bold;
                    padding: 10px;
                    background-color: #e0e0e0;
                    border-radius: 5px;
                    margin-bottom: 10px;
                    text-align: center; /* Centrar el texto del encabezado */
                }

                .card {
                    background-color: #ffffff;
                    border: 1px solid #ccc;
                    border-radius: 5px;
                    padding: 10px;
                    margin-bottom: 10px;
                    position: relative; /* For options positioning */
                }

                .card-options {
                    position: absolute;
                    top: 5px;
                    right: 5px;
                    cursor: pointer;
                }

                .create-button {
                    background-color: #ffffff;
                    border: 1px solid #ccc;
                    border-radius: 5px;
                    padding: 8px 12px;
                    cursor: pointer;
                    align-self: flex-start; /* Align to the start of the column */
                    margin-top: auto; /* Push to the bottom */
                    width: 100%; /* Ocupar todo el ancho del contenedor */
                    text-align: center; /* Centrar el texto del botón */
                }

                .add-column-button {
                    background-color: #ffffff;
                    border: 1px solid #ccc;
                    border-radius: 50%; /* Make it a circle */
                    width: 30px;
                    height: 30px;
                    font-size: 20px;
                    font-weight: bold;
                    cursor: pointer;
                    margin-left: 10px;
                    align-self: center; /* Vertically center the button */
                }

                /* Basic styling - adjust as needed */
            </style>

                               <!-- Parte COrregida del codigo -->


                </div>

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
        nuevaTarea.innerHTML = `<input type="text" placeholder="Descripción de la tarea">`;
        lista.appendChild(nuevaTarea);
    }
  </script>
    </div>

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
            <!-- Modal para agregar nueva columna -->
            <div id="modalAgregarColumna" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center hidden">
                <div class="bg-white p-6 rounded-lg shadow-lg w-1/3">
                    <h3 class="text-xl font-bold mb-4">Nombre de la Columna </h3>
                    <input type="text" id="nombreColumna" class="border p-2 w-full mb-4" placeholder="Nombre de la columna">
                    <div class="flex justify-end space-x-2">
                        <button onclick="cerrarModalAgregarColumna()" class="bg-red-500 text-white px-4 py-2 rounded">Cancelar</button>
                        <button onclick="guardarColumna()" class="bg-green-500 text-white px-4 py-2 rounded">Guardar</button>
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
        document.addEventListener('DOMContentLoaded', () => {
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


                            <div class="menu-opciones hidden absolute right-0 top-6 bg-white border rounded shadow-lg z-10">
                                <button class="editar-columna px-4 py-2 hover:bg-gray-100 w-full text-left">Editar Nombre</button>
                                <button class="eliminar-columna px-4 py-2 hover:bg-gray-100 w-full text-left">Eliminar Columna</button>
                            </div>
                        </div>
                    </div>
                    <div class="min-h-[150px] space-y-2 sortable"></div>
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
                                        toastr.success(`El estado de la historia ha cambiado a: ${nuevoEstado}.`);
                                    } else {
                                        toastr.error('Error al actualizar el estado.');
                                    }
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    toastr.error('No se pudo conectar con el servidor.');
                                });
                        }

                    });
                });
            }

            inicializarArrastrables();
            agregarEventosOpciones();
        });
    </script>

<script>
        document.addEventListener('DOMContentLoaded', () => {
            const buscarInput = document.getElementById('buscar');
            const filtrarEstado = document.getElementById('filtrarEstado');
            const filtrarFecha = document.getElementById('filtrarFecha');
            const filtrarResponsable = document.getElementById('filtrarResponsable');
            const limpiarFiltros = document.getElementById('limpiarFiltros');

            buscarInput.addEventListener('input', filtrarTareas);
            filtrarEstado.addEventListener('change', filtrarTareas);
            filtrarFecha.addEventListener('change', filtrarTareas);
            filtrarResponsable.addEventListener('change', filtrarTareas);
            limpiarFiltros.addEventListener('click', limpiarBusqueda);

            function filtrarTareas() {
                const textoBusqueda = buscarInput.value.toLowerCase();
                const estadoSeleccionado = filtrarEstado.value;
                const fechaSeleccionada = filtrarFecha.value;
                const responsableSeleccionado = filtrarResponsable.value;

                document.querySelectorAll('.card').forEach(card => {
                    const textoCard = card.textContent.toLowerCase();
                    const estadoCard = card.dataset.estado;
                    const fechaCard = card.dataset.fecha;
                    const responsableCard = card.dataset.responsable;

                    let mostrar = true;

                    if (textoBusqueda && !textoCard.includes(textoBusqueda)) mostrar = false;
                    if (estadoSeleccionado && estadoCard !== estadoSeleccionado) mostrar = false;
                    if (fechaSeleccionada && fechaCard !== fechaSeleccionada) mostrar = false;
                    if (responsableSeleccionado && responsableCard !== responsableSeleccionado) mostrar = false;

                    card.style.display = mostrar ? 'block' : 'none';
                });
            }

            function limpiarBusqueda() {
                buscarInput.value = "";
                filtrarEstado.value = "";
                filtrarFecha.value = "";
                filtrarResponsable.value = "";
                filtrarTareas();
            }

            document.getElementById('agregarColumna').addEventListener('click', () => {
                console.log("Columna agregada");
            });

        });
    </script>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const modalEtiquetas = document.getElementById('modalEtiquetas');
    const cerrarEtiquetas = document.getElementById('cerrarEtiquetas');
    const guardarEtiquetas = document.getElementById('guardarEtiquetas');
    const listaEtiquetas = document.getElementById('listaEtiquetas');
    let tarjetaSeleccionada = null;

    // Lista de etiquetas disponibles
    const etiquetasDisponibles = [
        { nombre: "Sin etiqueta", color: "bg-gray-400" },
        { nombre: "Urgente", color: "bg-red-500" },
        { nombre: "Bug", color: "bg-yellow-500" },
        { nombre: "Mejora", color: "bg-green-500" },
        { nombre: "Investigación", color: "bg-blue-500" }
    ];

    // Asignar "Sin etiqueta" a cada nueva tarjeta si no tiene
    document.querySelectorAll('.card').forEach((card, index) => {
        if (!card.dataset.id) {
            card.dataset.id = `tarea_${index}`;
        }
        if (!card.dataset.etiquetas) {
            card.dataset.etiquetas = "Sin etiqueta";
            mostrarEtiquetasEnTarea(card, "Sin etiqueta");
        }
    });

    // Restaurar etiquetas guardadas en localStorage
    document.querySelectorAll('.card').forEach(card => {
        const idTarea = card.dataset.id;
        const etiquetaGuardada = localStorage.getItem(`etiqueta_${idTarea}`);

        if (etiquetaGuardada) {
            card.dataset.etiquetas = etiquetaGuardada;
            mostrarEtiquetasEnTarea(card, etiquetaGuardada);
        } else {
            card.dataset.etiquetas = "Sin etiqueta"; // Asegura la etiqueta por defecto
            mostrarEtiquetasEnTarea(card, "Sin etiqueta");
        }
    });

    // Evento de doble clic para abrir el modal
    document.querySelectorAll('.card').forEach(card => {
        card.addEventListener('dblclick', (e) => {
            e.stopPropagation();
            abrirModal(card);
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
        localStorage.setItem(`etiqueta_${idTarea}`, etiquetaSeleccionada);

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
});


</script>
    <script>
        function abrirModalAgregarColumna() {
            // Verificar cuántas columnas existen en el tablero
            const columnasExistentes = document.querySelectorAll(`#tablero .kanban-column`).length;
            if (columnasExistentes >= 9) {
                alert("No se pueden agregar más de 9 columnas.");
                return; // No abrir el modal si ya hay 9 columnas
            }

            // Si hay menos de 9 columnas, entonces abre el modal
            document.getElementById('modalAgregarColumna').classList.remove('hidden');
        }

        function cerrarModalAgregarColumna() {
            document.getElementById('modalAgregarColumna').classList.add('hidden');
        }

        function guardarColumna() {
            const tableroId = {{ $tablero->id }}; // ID del tablero actual
            const nombreColumna = document.getElementById('nombreColumna').value;

            if (!nombreColumna) {
                alert("El nombre de la columna no puede estar vacío.");
                return;
            }

            // Verificar cuántas columnas existen en el tablero
            const columnasExistentes = document.querySelectorAll(`#tablero .kanban-column`).length;
            if (columnasExistentes >= 9) {
                alert("No se pueden agregar más de 9 columnas.");
                return; // No continuar si ya hay 9 columnas
            }

            fetch("{{ route('columnas.store', ['tablero' => $tablero->id]) }}", { // Agregar el parámetro 'tablero'
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                },
                body: JSON.stringify({
                    tablero_id: tableroId,
                    nombre: nombreColumna
                })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.mensaje === "Columna creada") {
                        const tablero = document.getElementById("tablero");
                        const nuevaColumna = document.createElement("div");
                        nuevaColumna.classList.add("kanban-column");
                        nuevaColumna.innerHTML = `
                    <div class="column-header">${data.columna.nombre}</div>
                    <div class="sortable"></div>
                    <button class="create-button" onclick="window.location.href='{{ route('formulario.create', $tablero->id) }}'">+ Crear Historia</button>
                `;
                        tablero.insertBefore(nuevaColumna, tablero.lastElementChild);
                        toastr.success("Columna agregada exitosamente.");
                        cerrarModalAgregarColumna();
                    } else {
                        toastr.error("Error al agregar la columna.");
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                    toastr.error("No se pudo conectar con el servidor.");
                });
        }


    </script>

@stop