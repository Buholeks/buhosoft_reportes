@csrf
<div class="form-group">
    <label>Nombre</label>
    <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $sucursal->nombre ?? '') }}" required>
</div>
<div class="form-group">
    <label>Dirección</label>
    <input type="text" name="direccion" class="form-control" value="{{ old('direccion', $sucursal->direccion ?? '') }}">
</div>
<div class="form-group">
    <label>Teléfono</label>
    <input type="text" name="numero_tel" class="form-control" value="{{ old('numero_tel', $sucursal->numero_tel ?? '') }}">
</div>
<div class="form-group">
    <label>Prefijo Folio</label>
    <input type="text" name="prefijo_folio_sucursal" class="form-control" value="{{ old('prefijo_folio_sucursal', $sucursal->prefijo_folio_sucursal ?? '') }}">
</div>
