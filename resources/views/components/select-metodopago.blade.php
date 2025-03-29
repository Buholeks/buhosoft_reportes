
<div>
    <select name="{{ $name }}" id="{{ $name }}" class="form-control metodopago">
        <option value="">Seleccione</option>
        @foreach ($options as $id => $nombre)
            <option value="{{ $id }}"
                {{ old($name) == $id ? 'selected' : '' }}>
                {{ $nombre }}
            </option>
        @endforeach
    </select>
</div>