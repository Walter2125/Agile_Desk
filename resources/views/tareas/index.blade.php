@extends('adminlte::page')
@section('title', 'Agile Desk')
@section("adminlte_css")

@section('content')

     
 <table class="table">
  <thead>
    <tr>
      <th scope="col">Nombre</th>
      <th scope="col">Descripcion</th>
      <th scope="col">Historial</th>
      <th scope="col">Actividad</th>
      <th scope="col">Asignado</th> 
      <th scope="col">Historia</th>
      <th scope="col">Botones</th>
    </tr>
  </thead>
  <tbody>
    @foreach ( $tareas as $tarea )
    <tr>
      <th scope="row">{{ $tarea->nombre }}</th>
      <td>{{ $tarea->descripcion }}</td>
      <td>{{ $tarea->historial }}</td>
      <td>{{ $tarea->actividad }}</td>
      <td>{{ $tarea->asignado }}</td>
      <td>{{ $tarea->historia ? $tarea->historia->nombre : 'Sin historia' }}</td>
      <td><a href="{{ route('tareas.edit',$tarea->id) }}" class="btn btn-primary">Edit</a> </td>


    

    </tr>
    @endforeach
    </tbody>
</table>


@endsection
@stop