@extends('adminlte::page')

@section('title', 'Detalle del Sprint')

@section('content')
<div class="container py-4">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title">Sprint: {{ $sprint->nombre }}</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Fecha inicio:</strong> {{ $sprint->fecha_inicio->format('d/m/Y') }}</p>
                    <p><strong>Fecha fin:</strong> {{ $sprint->fecha_fin->format('d/m/Y') }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Color:</strong> <span class="px-2 rounded" style="background-color: {{ $sprint->color }}">{{ $sprint->color }}</span></p>
                    <p><strong>Proyecto:</strong> {{ $sprint->project->name }}</p>
                </div>
            </div>

            <div class="mt-4">
                <h4>Historias en este Sprint</h4>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Estado</th>
                                <th>Prioridad</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($sprint->historias as $historia)
                                <tr>
                                    <td>{{ $historia->id }}</td>
                                    <td>{{ $historia->nombre }}</td>
                                    <td>{{ $historia->estado }}</td>
                                    <td>{{ $historia->prioridad }}</td>
                                    <td>
                                        <a href="{{ route('formulario.show', $historia->id) }}" class="btn btn-sm btn-info">Ver</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">No hay historias en este sprint</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
