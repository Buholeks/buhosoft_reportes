@extends('layouts.app')

@section('content')
<h1>Listado de Sucursales</h1>
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalSucursal">
    Nueva Sucursal
</button>

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
                <a href="{{ route('sucursales.edit', $sucursal) }}" class="btn btn-sm btn-warning">Editar</a>
                <form action="{{ route('sucursales.destroy', $sucursal) }}" method="POST" style="display:inline;">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
