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
    <a href="{{ route('proyectos.historialcambios.index', ['project' => $tablero->project->id]) }}" 
   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded w-auto sm:w-24">
   Historial de Cambios</a>  
   <a href="{{ route('reasignar.index', ['project' => $project->id]) }}"
   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded w-auto sm:w-24">
   Reasignar Historias</a>    
</div>

<a href="{{ route('archivo.seleccionar', ['project' => $project->id]) }}" class="btn btn-warning">
    📦 Archivar Historia
</a>

<a href="{{ route('archivo.index.proyecto', ['project' => $project->id]) }}" class="btn btn-sm btn-light me-2">
    <i class="fas fa-archive me-1"></i> Ver Archivadas
</a>
        </div>
    </div>
</div>


            <div class="flex justify-between mb-4 items-center">

                <select id="comboboxColumna" class="border p-2 rounded">
                    <option value="">Seleccionar opción</option>
                    <option value="opcion1">Sprint 1</option>
                    <option value="opcion2">Sprint 2</option>
                    <option value="opcion3">Sprint 3</option>
                    <option value="opcion4">Sprint 4</option>
                    <option value="opcion5">Sprint 5</option>
                </select>

                <button id="agregarColumna" class="bg-green-500 text-white px-4 py-2 rounded">
                    Agregar Columna
                </button>
            </div>


            <div id="tablero" class="flex space-x-4 w-full overflow-x-auto p-2">
                <div class="columna bg-pink-100 p-4 rounded w-full sm:w-60 flex-shrink-0">
                    <div class="flex justify-between items-center">
                        <span class="titulo-columna text-lg font-bold text-pink-800" style="font-size: 30px; line-height: 1.2;">Backlog</span>
                        <div class="relative">

                            <div class="btn-group dropend">
                                <!-- Botón del Dropend -->
                                <button type="button" class="btn btn-secondary dropdown-toggle absolute right-0 top-6 bg-white border rounded shadow-lg " data-bs-toggle="dropdown" aria-expanded="false" style="position: relative; top: -2px; height: 28px; width: 28px; font-size: 14px; padding: 4px;">
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
                                            Editar Nombre
                                        </button>
                                    </li>
                                </ul>
                            </div>

                               <!-- Parte COrregida del codigo -->

                            <div class="menu-opciones hidden absolute right-0 top-6 bg-white border rounded shadow-lg z-10">
                                <button class="editar-columna px-4 py-2 hover:bg-gray-100 w-full text-left">Editar Nombre</button>
                                <div class="container my-4"><div class="col-md-2"><a href="{{ route('formulario.create', $tablero->id) }}" class="btn btn-primary"><i class="bi bi-plus"></i> Crear</a></div></div>
                                </button>
                            </div>
                        </div>
                    </div>
                <div class="min-h-[150px] space-y-2 sortable" style="margin-top: 20px;">


                    <!-- Para ordenarlos según la prioridad -->
                    <div class="min-h-[200px] space-y-4 sortable">
                        @forelse ($tablero->historias as $historia)
                            <a href="{{ route('formulario.show', $historia->id) }}" class="block no-underline">
                                <div class="card bg-white p-2 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-200 cursor-pointer">
                                    <div class="flex justify-start items-start mb-1 gap-1">
                                        <div class="font-bold text-lg text-black truncate max-w-[200%]" title="{{ $historia->nombre }}">
                                            {{ $historia->nombre }}
                    
                                            <div class="flex space-x-1 shrink-0">
                                                <a href="{{ route('formulario.edit', $historia->id) }}" class="text-blue-500 hover:text-blue-700 transition-colors">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <button type="button"
                                                        class="text-red-500 hover:text-red-700 transition-colors"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#confirmDeleteModal-{{ $historia->id }}">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                    
                                            <!-- Modal de confirmación -->
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
                                                            <form action="{{ route('formulario.destroy', $historia->id) }}" method="post">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger">Eliminar</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                    
                                            <!-- Información de la historia -->
                                            <div class="mb-3">
                                                <div class="flex items-center mb-1">
                                                    <span class="text-gray-600 mr-2 shrink-0">Id:</span>
                                                    <span class="font-semibold text-gray-800">{{ $historia->id }}</span>
                                                </div>
                                                <div class="flex items-center">
                                                    <span class="text-gray-600 mr-2 shrink-0">Prioridad:</span>
                                                    <span class="font-semibold text-gray-800">{{ $historia->prioridad }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <p class="text-gray-500 italic">No hay historias creadas.</p>
                        @endforelse
                    </div>
                    
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
@stop
