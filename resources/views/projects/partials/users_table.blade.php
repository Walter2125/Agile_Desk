<table class="table">
    <thead>
        <tr>
            <th>Seleccionar</th>
            <th>Nombre</th>
            <th>Email</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
        @if ($user->usertype !== 'admin')
            <tr>
                <td>
                <input type="checkbox" class="user-checkbox" value="{{ $user->id }}" id="user_{{ $user->id }}"
                @if(isset($selectedUsers) && in_array($user->id, $selectedUsers)) checked @endif>

                </td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
            </tr>
            @endif
        @endforeach
    </tbody>
</table>


