<!-- resources/views/usuarios/edit.blade.php -->
@extends('layouts.app')

@section('title', 'Editar Usuario')

@section('content')
<div class="container mt-4">
    <h2>Editar Usuario</h2>
    <form action="{{ route('usuarios.update', $usuario->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Nombre</label>
            <input type="text" class="form-control" name="name" value="{{ $usuario->name }}" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Correo Electrónico</label>
            <input type="email" class="form-control" name="email" value="{{ $usuario->email }}" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Nueva Contraseña (Opcional)</label>
            <input type="password" class="form-control" name="password">
        </div>
        <button type="submit" class="btn btn-primary">Actualizar Usuario</button>
        <a href="{{ url()->previous() }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
