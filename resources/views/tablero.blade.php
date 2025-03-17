@extends('adminlte::page')

@section('title', 'Agile Desk')

@section('adminlte_css')

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('style.css') }}">

    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
@stop

@section('content')
    <div class="bg-gray-100 p-10" style="background-color: rgba(243, 244, 246, 0.5);">
        <div class="w-full mx-auto bg-white p-6 rounded-lg shadow-lg overflow-x-auto h-screen">
            <h2 class="text-2xl font-bold text-center mb-6">Tablero Scrum</h2>

            <!-- Barra de búsqueda y filtros -->
            <div class="flex flex-wrap items-center justify-between mb-4 space-y-2">
                <input type="text" id="buscar" class="border p-2 rounded w-1/3" placeholder="Buscar historias o tareas...">
                
                <select id="filtrarEstado" class="border p-2 rounded">
                    <option value="">Todos los estados</option>
                    <option value="Historia">Historia</option>
                    <option value="Tarea">Tarea</option>
                </select>

                <input type="date" id="filtrarFecha" class="border p-2 rounded">

                <select id="filtrarResponsable" class="border p-2 rounded">
                <option value="">Todos los responsables</option>
    
                @if (!empty($responsables))
                @foreach ($responsables as $responsable)
            <option value="{{ $responsable }}">{{ $responsable }}</option>
            @endforeach
            @endif
           </select>

           <select id="filtrarEtiqueta" class="border p-2 rounded">
                    <option value="">Todas las etiquetas</option>
                </select>

                <button id="limpiarFiltros" class="bg-red-500 text-white px-4 py-2 rounded">Limpiar</button>
            </div>

            <div class="flex justify-between mb-4">
                <button id="agregarColumna" class="bg-green-500 text-white px-4 py-2 rounded">Agregar Columna</button>
            </div>

            <div id="tablero" class="flex space-x-4 w-full overflow-x-auto p-2">
                <div class="columna bg-pink-100 p-4 rounded w-full sm:w-60 flex-shrink-0">
                    <div class="flex justify-between items-center">
                        <span class="titulo-columna text-lg font-bold text-pink-800">Historia</span>
                        <div class="relative">
                            <button class="opciones-columna text-gray-700">⋮</button>
                            <div class="menu-opciones hidden absolute right-0 top-6 bg-white border rounded shadow-lg z-10">
                                <button class="editar-columna px-4 py-2 hover:bg-gray-100 w-full text-left">Editar Nombre</button>
                                <button class="agregar-tarea px-4 py-2 hover:bg-gray-100 w-full text-left">Agregar Historia</button>
                            </div>
                        </div>
                    </div>
                    <div class="min-h-[150px] space-y-2 sortable">
                    <div class="card bg-white p-3 rounded shadow cursor-pointer">Modo de reunión</div>
                        <div class="card bg-white p-3 rounded shadow cursor-pointer">Reflejo de imágenes</div>
                    </div>
                </div>
            </div>
        </div>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Sortable JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <!--Script personalizado para manejo del tema -->
    <script src="{{ asset('color.js') }}"></script>
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
                        <span class="titulo-columna text-lg font-bold">Nueva columna</span>
                        <div class="relative">
                            <button class="opciones-columna text-gray-700">⋮</button>
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

                document.querySelectorAll('.editar-columna').forEach(btn => {
                    btn.addEventListener('click', () => {
                        columnaActual = btn.closest('.columna');
                        const titulo = columnaActual.querySelector('.titulo-columna').textContent;
                        nuevoNombreInput.value = titulo;
                        modal.classList.remove('hidden');
                    });
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

                document.querySelectorAll('.card').forEach(card => {
                    card.addEventListener('dblclick', () => {
                        if (confirm('¿Eliminar esta tarea?')) {
                            card.remove();
                        }
                    });
                });
            }

            function inicializarArrastrables() {
                document.querySelectorAll('.sortable').forEach(el => {
                    new Sortable(el, {
                        group: 'scrum',
                        animation: 150,
                        onEnd(evt) {
                            const tarjeta = evt.item;
                            const columnaDestino = evt.from.closest('.columna');
                            const estado = columnaDestino.querySelector('.titulo-columna').textContent;

                            const nombreHistoria = tarjeta.textContent.trim();


                            toastr.success(`La historia ${nombreHistoria} ha cambiado a ${estado}.`);

                            tarjeta.classList.add('bg-yellow-100'); // Puedes personalizar el color
                        }
                    });
                });
            }

            document.getElementById('cancelar').addEventListener('click', () => {
                modal.classList.add('hidden');
            });

            document.getElementById('guardar').addEventListener('click', () => {
                const nuevoNombre = nuevoNombreInput.value;
                if (nuevoNombre) {
                    columnaActual.querySelector('.titulo-columna').textContent = nuevoNombre;
                    modal.classList.add('hidden');
                }
            });

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
            const filtrarEtiqueta = document.getElementById('filtrarEtiqueta');

            const etiquetasDisponibles = [
                { nombre: "Urgente", color: "bg-red-500" },
                { nombre: "Bug", color: "bg-yellow-500" },
                { nombre: "Mejora", color: "bg-green-500" },
                { nombre: "Investigación", color: "bg-blue-500" }
            ];

            etiquetasDisponibles.forEach(etiqueta => {
                const option = document.createElement('option');
                option.value = etiqueta.nombre;
                option.textContent = etiqueta.nombre;
                filtrarEtiqueta.appendChild(option);
            });

            document.querySelectorAll('.card').forEach(card => {
                card.addEventListener('dblclick', () => {
                    modalEtiquetas.classList.remove('hidden');
                    modalEtiquetas.dataset.target = card;
                    generarOpcionesEtiquetas(card);
                });
            });

            function generarOpcionesEtiquetas(card) {
                listaEtiquetas.innerHTML = "";
                etiquetasDisponibles.forEach(etiqueta => {
                    const div = document.createElement('div');
                    div.classList.add('flex', 'items-center', 'space-x-2');

                    const checkbox = document.createElement('input');
                    checkbox.type = 'checkbox';
                    checkbox.value = etiqueta.nombre;
                    checkbox.checked = card.dataset.etiquetas?.includes(etiqueta.nombre) || false;
                    
                    const label = document.createElement('span');
                    label.textContent = etiqueta.nombre;
                    label.classList.add('px-2', 'py-1', 'rounded', etiqueta.color, 'text-white');

                    div.appendChild(checkbox);
                    div.appendChild(label);
                    listaEtiquetas.appendChild(div);
                });
            }

            guardarEtiquetas.addEventListener('click', () => {
                const targetCard = modalEtiquetas.dataset.target;
                const etiquetasSeleccionadas = Array.from(listaEtiquetas.querySelectorAll('input:checked'))
                                                    .map(input => input.value);
                targetCard.dataset.etiquetas = etiquetasSeleccionadas.join(',');
                mostrarEtiquetasEnTarea(targetCard, etiquetasSeleccionadas);
                
                if (etiquetasSeleccionadas.includes("Urgente")) {
                    toastr.warning("Tarea marcada como Urgente. Notificando al líder técnico...");
                }

                modalEtiquetas.classList.add('hidden');
            });

            function mostrarEtiquetasEnTarea(card, etiquetas) {
                let etiquetaContainer = card.querySelector('.etiquetas');
                if (!etiquetaContainer) {
                    etiquetaContainer = document.createElement('div');
                    etiquetaContainer.classList.add('flex', 'space-x-1', 'mt-2', 'etiquetas');
                    card.appendChild(etiquetaContainer);
                }
                etiquetaContainer.innerHTML = "";

                etiquetas.forEach(nombreEtiqueta => {
                    const etiquetaData = etiquetasDisponibles.find(e => e.nombre === nombreEtiqueta);
                    const etiquetaSpan = document.createElement('span');
                    etiquetaSpan.textContent = nombreEtiqueta;
                    etiquetaSpan.classList.add('px-2', 'py-1', 'text-white', 'rounded', etiquetaData.color);
                    etiquetaContainer.appendChild(etiquetaSpan);
                });
            }
        });
    </script>
@stop
