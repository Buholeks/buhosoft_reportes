@extends('layouts.app')

@section('content')
<h1>Listado de Sucursales</h1>
@can('nueva sucursal')
<a href="{{ route('sucursales.create') }}" class="btn btn-primary">Nueva Sucursal</a>
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalSucursal">
  Nueva Sucursal
</button>
@endcan
<table class="table mt-3">
  <thead>
    <tr>
      <th>Nombre</th>
      <th>Dirección</th>
      <th>Teléfono</th>
      <th>Prefijo</th>
      <th>Acciones</th>
    </tr>
  </thead>
  <tbody>
    @foreach($sucursales as $sucursal)
    <tr>
      <td>{{ $sucursal->nombre }}</td>
      <td>{{ $sucursal->direccion }}</td>
      <td>{{ $sucursal->numero_tel }}</td>
      <td>{{ $sucursal->prefijo_folio_sucursal }}</td>
      <td>
        @can('editar sucursal')
        <a href="{{ route('sucursales.edit', $sucursal) }}" class="btn btn-sm btn-warning">Editar</a>
        @endcan
        @can('eliminar sucursal')
        <form action="{{ route('sucursales.destroy', $sucursal) }}" method="POST" style="display:inline;">
          @csrf @method('DELETE')
          <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
        </form>
        @endcan
      </td>
    </tr>
    @endforeach
  </tbody>
</table>




<!-- Modal para crear nueva sucursal -->
<div class="modal fade" id="modalSucursal" tabindex="-1" aria-labelledby="modalSucursalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('sucursales.store') }}" method="POST">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="modalSucursalLabel">Nueva Sucursal</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          @include('sucursales._form', ['sucursal' => null])
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Guardar</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection