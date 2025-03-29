<div>
<select name="{{ $name }}" id="{{ $name }}" class="form-control tipoventa">
    <option value=""></option>
    @foreach ($options as $id => $nombre)
        <option value="{{ $id }}">{{ $nombre }}</option>
    @endforeach
</select>
</div>