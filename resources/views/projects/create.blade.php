@extends('adminlte::page')

@section('content')
    <div class="container mt-5">
    <h1>Crear Proyecto</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

                        <form action="{{ route('projects.store') }}" method="POST">
                            @csrf

        <!-- Nombre del Proyecto -->
                            <div class="mb-3">
                                <label for="name" class="form-label">Nombre del Proyecto</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>

        <!-- Número del Sprint -->
                            <div class="mb-3">
                                <label for="sprint_number" class="form-label">Número de Sprint</label>
                                <input type="number" class="form-control" id="sprint_number" name="sprint_number" required>
                            </div>

        <!-- Buscador de Usuarios -->
                            <div class="mb-3">
                                <label for="user_search" class="form-label">Buscar Usuarios</label>
            <input type="text" class="form-control" id="user_search" placeholder="Escriba un nombre...">
            <div id="user_results" class="list-group mt-2"></div>
                            </div>

        <!-- Botón para Añadir Miembro -->
        <button type="button" id="add_member" class="btn btn-success">Añadir Miembro</button>

        <!-- Tabla de Usuarios Seleccionados -->
        <div class="mt-4">
                                <h4>Usuarios Seleccionados</h4>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Acción</th>
                                        </tr>
                                    </thead>
                                    <tbody id="selected_users"></tbody>
                                </table>
                            </div>

        <!-- Input Oculto para Enviar IDs -->
                            <input type="hidden" name="users" id="users">

        <!-- Botón para Guardar Proyecto -->
        <button type="submit" class="btn btn-primary mt-3">Guardar Proyecto</button>
                        </form>
                    </div>

<!-- Scripts -->
    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let selectedUsers = [];

            // Buscar Usuarios con Fetch
            document.getElementById("user_search").addEventListener("input", function () {
                let query = this.value;
                let userResults = document.getElementById("user_results");
                userResults.innerHTML = ""; // Limpiar resultados previos

                if (query.length >= 2) {
                    fetch("/users/search?query=" + encodeURIComponent(query), {
                        method: "GET",
                        headers: { "X-Requested-With": "XMLHttpRequest" }
                    })
                    .then(response => response.json())
                    .then(users => {
                        users.forEach(user => {
                            let button = document.createElement("button");
                            button.type = "button";
                            button.className = "list-group-item list-group-item-action add-user";
                            button.dataset.id = user.id;
                            button.dataset.name = user.name;
                            button.textContent = user.name;
                            userResults.appendChild(button);
                        });
                    })
                    .catch(error => console.error("Error al buscar usuarios", error));
                }
            });

            // Añadir Usuario a la Tabla Temporal
            document.getElementById("user_results").addEventListener("click", function (event) {
                if (event.target.classList.contains("add-user")) {
                    let userId = event.target.dataset.id;
                    let userName = event.target.dataset.name;
                    let selectedUsersTable = document.getElementById("selected_users");

                    if (!selectedUsers.includes(userId)) {
                        selectedUsers.push(userId);
                        let row = document.createElement("tr");
                        row.dataset.id = userId;
                        row.innerHTML = `
                            <td>${userName}</td>
                            <td><button type="button" class="btn btn-danger btn-sm remove-user">Eliminar</button></td>
                        `;
                        selectedUsersTable.appendChild(row);
                        updateUsersInput();
                    }
                }
            });

            // Eliminar Usuario de la Tabla Temporal
            document.getElementById("selected_users").addEventListener("click", function (event) {
                if (event.target.classList.contains("remove-user")) {
                    let row = event.target.closest("tr");
                    let userId = row.dataset.id;
                    selectedUsers = selectedUsers.filter(id => id !== userId);
                    row.remove();
                    updateUsersInput();
                }
            });

            // Actualizar el Campo Oculto con los IDs de los Usuarios Seleccionados
            function updateUsersInput() {
                document.getElementById("users").value = selectedUsers.join(",");
            }
        });

    </script>
@endsection
