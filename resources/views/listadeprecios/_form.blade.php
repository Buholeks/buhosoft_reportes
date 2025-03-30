{{-- resources/views/listadeprecios/_form.blade.php --}}
<form method="POST" action="{{ route('listadeprecios.store') }}">
    @csrf

    <div class="modal-header">
        <h5 class="modal-title">Crear Precio</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    </div>

    <div class="modal-body">

        <div class="mb-3">
            <label for="descripcion">Descripción:</label>
            <input type="text" name="descripcion" id="descripcion" class="form-control"
                value="{{ old('descripcion') }}" required>
        </div>

        <div class="mb-3">
            <label for="tipoe">Tipo de Producto</label>
            <select name="tipoe" id="tipoe" class="form-select">
                <option value="">Seleccione una opción</option>
                @foreach($tiposEquipos as $tipoproducto)
                    <option value="{{ $tipoproducto->id }}"
                        {{ old('tipoe') == $tipoproducto->id ? 'selected' : '' }}>
                        {{ $tipoproducto->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="tipove">Método de Pago</label>
            <select name="tipove" id="tipove" class="form-select">
                <option value="">Seleccione una opción</option>
                @foreach($tiposVentas as $metodopago)
                    <option value="{{ $metodopago->id }}"
                        {{ old('tipove') == $metodopago->id ? 'selected' : '' }}>
                        {{ $metodopago->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="precio">Precio:</label>
            <input type="number" step="0.01" name="precio" id="precio" class="form-control"
                value="{{ old('precio') }}" required>
        </div>

        <div class="mb-3">
            <label for="precio_promocion">Precio Promoción:</label>
            <input type="number" step="0.01" name="precio_promocion" id="precio_promocion" class="form-control"
                value="{{ old('precio_promocion') }}">
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-primary">Guardar</button>
    </div>
</form>
