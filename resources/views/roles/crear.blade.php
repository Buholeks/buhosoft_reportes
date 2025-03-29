<!-- resources/views/roles/create.blade.php -->
@extends('layouts.app')

@section('title', 'Crear Rol')

@section('content')
<div class="container mt-4">
    <h2>Crear Rol</h2>
    <form action="{{ route('roles.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Nombre del Rol</label>
            <input type="text" class="form-control" name="name" required>
        </div>
        <button type="submit" class="btn btn-primary">Guardar Rol</button>
        <a href="{{ url()->previous() }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection