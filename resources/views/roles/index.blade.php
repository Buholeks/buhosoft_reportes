<!-- resources/views/roles/index.blade.php -->
@extends('layouts.app')

@section('title', 'Roles')

@section('content')
<div class="container mt-4">
    <h2>Lista de Roles</h2>
    
    @can('crear roles')
    <a href="{{ route('roles.create') }}" class="btn btn-success mb-3">Crear Rol</a>
    @endcan
    
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Permisos</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($roles as $rol)
            <tr>
                <td>{{ $rol->id }}</td>
                <td>{{ $rol->name }}</td>
                <td>{{ implode(', ', $rol->permissions->pluck('name')->toArray()) }}</td>
                <td>
                    @can('editar roles')
                    <a href="{{ route('roles.permisos', $rol->id) }}" class="btn btn-info">Permisos</a>
                    @endcan
                    
                    @can('eliminar roles')
                    <form action="{{ route('roles.destroy', $rol->id) }}" method="POST" style="display:inline;">
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