<!-- resources/views/usuarios/roles.blade.php -->
@extends('layouts.app')


@section('title', 'Asignar Roles al Usuario')

@section('content')
<div class="container mt-4">
    <h2>Asignar Roles a {{ $usuario->name }}</h2>
    <form action="{{ route('usuarios.actualizarRoles', $usuario->id) }}" method="POST">
        @csrf
        <div class="mb-3">
            @foreach ($roles as $rol)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $rol->name }}" 
                        {{ $usuario->hasRole($rol->name) ? 'checked' : '' }}>
                    <label class="form-check-label">{{ $rol->name }}</label>
                </div>
            @endforeach
        </div>
        <button type="submit" class="btn btn-primary">Guardar Roles</button>
        <a href="{{ url()->previous() }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
