@extends('layouts.app')

@section('title', 'Usuarios')

@section('content')
<div class="container mt-4">
    <h2>Lista de Usuarios</h2>
    
    @can('crear usuarios')
    <a href="{{ route('usuarios.create') }}" class="btn btn-success mb-3">Crear Usuario</a>
    @endcan
    
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Roles</th>
                <th>Permiso Especial</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($usuarios as $usuario)
            <tr>
                <td>{{ $usuario->id }}</td>
                <td>{{ $usuario->name }}</td>
                <td>{{ $usuario->email }}</td>
                <td>{{ implode(', ', $usuario->getRoleNames()->toArray()) }}</td>
                <td>{{ implode(', ', $usuario->getPermissionNames()->toArray()) }}</td>
                <td>
                    @can('editar usuarios')
                    <a href="{{ route('usuarios.edit', $usuario->id) }}" class="btn btn-warning">Editar</a>
                    @endcan
                    
                    @can('asignar roles')
                    <a href="{{ route('usuarios.roles', $usuario->id) }}" class="btn btn-primary">Roles</a>
                    @endcan
                    
                    @can('asignar permisos')
                    <a href="{{ route('usuarios.permisos', $usuario->id) }}" class="btn btn-info">Permiso Especial</a>
                    @endcan
                    
                    @can('eliminar usuarios')
                    <form action="{{ route('usuarios.destroy', $usuario->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                    @endcan
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection