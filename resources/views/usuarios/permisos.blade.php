<!-- resources/views/usuarios/permisos.blade.php -->
@extends('layouts.app')
@section('title', 'Asignar Permisos al Usuario')

@section('content')
<div class="container mt-4">
    <h2>Asignar Permisos a {{ $usuario->name }}</h2>

    <form action="{{ route('usuarios.actualizarPermisos', $usuario->id) }}" method="POST">
        @csrf

        <!-- Contenedor de grid con columnas dinámicas -->
        <div class="row">
            @foreach ($permisos as $categoria => $listaPermisos)
            @php
            $slugCategoria = Str::slug($categoria, '-'); // Convierte espacios en guiones para JavaScript
            @endphp

            <!-- Cada categoría ocupará 1/4 del ancho (col-md-3) -->
            <div class="col-md-4 mb-3">
                <div class="border p-3 rounded bg-light">
                    <h4 class="text-primary text-center">{{ ucfirst($categoria) }}</h4>
                    <hr>
                    <!-- Checkbox para seleccionar todos -->
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input select-all" data-category="{{ $slugCategoria }}">
                        <label class="form-check-label font-weight-bold">Todos los permisos en  {{ $slugCategoria }}</label>
                    </div>

                    @foreach ($listaPermisos as $permiso)
                    <div class="form-check">
                        <input class="form-check-input {{ $slugCategoria }}-checkbox" type="checkbox" name="permisos[]" value="{{ $permiso->name }}"
                            {{ $usuario->hasPermissionTo($permiso->name) ? 'checked' : '' }}>
                        <label class="form-check-label">{{ $permiso->name }}</label>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
        <button type="submit" class="btn btn-primary mt-3">Guardar Permisos</button>
        <button type="button" class="btn btn-secondary mt-3" onclick="window.history.back();">Cancelar</button>
    </form>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const selectAllCheckboxes = document.querySelectorAll(".select-all");

        selectAllCheckboxes.forEach(selectAll => {
            selectAll.addEventListener("change", function() {
                let category = this.getAttribute("data-category");
                let checkboxes = document.querySelectorAll(`.${category}-checkbox`);

                checkboxes.forEach(checkbox => {
                    checkbox.checked = selectAll.checked;
                });
            });
        });
    });
</script>
@endsection