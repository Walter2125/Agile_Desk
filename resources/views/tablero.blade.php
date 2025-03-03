@extends('adminlte::page')

@section('title', 'Agile Desk')

@section('adminlte_css')
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Tu CSS personalizado -->
    <link rel="stylesheet" href="{{ asset('style.css') }}">
    <!-- Tailwind CSS (se incluye aquí para que se cargue en el head) -->
    <script src="https://cdn.tailwindcss.com"></script>
@stop

@section('content')
    <div class="bg-gray-100 p-10" style="background-color: rgba(243, 244, 246, 0.5);">
        <div class="w-full mx-auto bg-white p-6 rounded-lg shadow-lg overflow-x-auto h-screen">
            <h2 class="text-2xl font-bold text-center mb-6">Tablero Scrum</h2>
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
                                <button class="eliminar-columna px-4 py-2 hover:bg-gray-100 w-full text-left">Eliminar Columna</button>
                                <button class="agregar-tarea px-4 py-2 hover:bg-gray-100 w-full text-left">Agregar Tarea</button>
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
@stop

@section('adminlte_js')
    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Sortable JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
    <!-- Tu script personalizado para manejo del tema -->
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
                                <button class="agregar-tarea px-4 py-2 hover:bg-gray-100 w-full text-left">Agregar Tarea</button>
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
                        const columna = btn.closest('.columna');
                        const tareaTexto = prompt('Texto de la nueva tarea:');
                        if (tareaTexto) {
                            const nuevaTarea = document.createElement('div');
                            nuevaTarea.classList.add('card', 'bg-white', 'p-3', 'rounded', 'shadow', 'cursor-pointer');
                            nuevaTarea.textContent = tareaTexto;
                            columna.querySelector('.sortable').appendChild(nuevaTarea);

                            // Agregar evento de doble clic al agregar una nueva tarea
                            nuevaTarea.addEventListener('dblclick', () => {
                                if (confirm('¿Eliminar esta tarea?')) {
                                    nuevaTarea.remove();
                                }
                            });
                        }
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
                        animation: 150
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
@stop
