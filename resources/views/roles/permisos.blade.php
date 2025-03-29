<!-- resources/views/roles/permisos.blade.php -->
@extends('layouts.app')

@section('title', 'Asignar Permisos al Rol')

@section('content')
<div class="container mt-4">
    <h2>Asignar Permisos a {{ $rol->name }}</h2>

    <form action="{{ route('roles.asignarPermisos', $rol->id) }}" method="POST">
        @csrf

        <!-- Contenedor de grid con columnas -->
        <div class="row">
            @foreach ($permisos as $categoria => $listaPermisos)
                @php 
                    $slugCategoria = Str::slug($categoria, '-'); // Convierte espacios en guiones para usar en el JS
                @endphp

                <!-- Cada categoría ocupa 1/4 del ancho (col-md-3) -->
                <div class="col-md-3 mb-4">
                    <div class="border p-3 rounded bg-light">
                        <h4 class="text-primary">{{ ucfirst($categoria) }}</h4>
                        <hr>
                        <!-- Checkbox para seleccionar todos -->
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input select-all" data-category="{{ $slugCategoria }}">
                            <label class="form-check-label font-weight-bold">Seleccionar todos</label>
                        </div>

                        @foreach ($listaPermisos as $permiso)
                            <div class="form-check">
                                <input class="form-check-input {{ $slugCategoria }}-checkbox" type="checkbox" name="permisos[]" value="{{ $permiso->name }}" 
                                    {{ $rol->hasPermissionTo($permiso->name) ? 'checked' : '' }}>
                                <label class="form-check-label">{{ $permiso->name }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>

        <div class="d-flex gap-2">
            <a href="{{ url()->previous() }}" class="btn btn-secondary mt-3">Cancelar</a>
            <button type="submit" class="btn btn-primary mt-3">Guardar Permisos</button>
        </div>
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
