<table class="table table-bordered table-striped" id="users_table">
    <thead>
        <tr>
            <th>Seleccionar</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Rol</th>
            <th>Fecha de creación</th>
        </tr>
    </thead>
    <tbody id="user_list">
        @foreach ($users as $user)
            <tr>
                <td>
                    <input type="checkbox" class="user-checkbox" id="user_{{ $user->id }}" 
                           name="user_checkbox[]" value="{{ $user->id }}">
                </td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    <span class="badge bg-{{ $user->role == 'admin' ? 'danger' : 'primary' }}">
                        {{ $user->role }}
                    </span>
                </td>
                <td>{{ $user->created_at->format('d/m/Y H:i') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>