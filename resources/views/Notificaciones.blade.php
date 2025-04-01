@extends('adminlte::page')

@section('title', 'Notificaciones - Agile Desk')

@section('content_header')
    <h1>Notificaciones</h1>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Todas las notificaciones</h3>
                    
                    <div class="card-tools">
                        <form action="{{ route('notificaciones.markAllAsRead') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-primary">
                                <i class="fas fa-check-double"></i> Marcar todas como leídas
                            </button>
                        </form>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Título</th>
                                    <th>Mensaje</th>
                                    <th>Fecha</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($notificaciones as $notificacion)
                                    <tr class="{{ $notificacion->read ? '' : 'bg-light' }}">
                                        <td>{{ $notificacion->title }}</td>
                                        <td>{{ $notificacion->message }}</td>
                                        <td>{{ $notificacion->created_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            @if($notificacion->read)
                                                <span class="badge badge-success">Leída</span>
                                            @else
                                                <span class="badge badge-warning">No leída</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                @if(!$notificacion->read)
                                                    <form action="{{ route('notificaciones.markAsRead', $notificacion->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-info">
                                                            <i class="fas fa-check"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                                <form action="{{ route('notificaciones.destroy', $notificacion->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de eliminar esta notificación?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No hay notificaciones disponibles</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
    <script>
        // Flash messages
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });
        
        // Show success message if exists
        @if(session('success'))
            Toast.fire({
                icon: 'success',
                title: '{{ session('success') }}'
            });
        @endif
        
        // Show error message if exists
        @if(session('error'))
            Toast.fire({
                icon: 'error',
                title: '{{ session('error') }}'
            });
        @endif
    </script>
@stop