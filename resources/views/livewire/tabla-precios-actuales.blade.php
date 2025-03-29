<div class="table-responsive mt-4">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Descripción</th>
                <th>Compañía</th>
                <th>Tipo</th>
                <th>Precio Antes</th>
                <th>Precio Ahora</th>
                <th>Comentario</th>
            </tr>
        </thead>
        <tbody>
            @foreach($precios as $precio)
                <tr class="
                    {{ $precio->precio_promocion > $precio->precio ? 'table-danger' : '' }}
                    {{ $precio->precio_promocion < $precio->precio ? 'table-success' : '' }}
                ">
                    <td>{{ $precio->descripcion }}</td>
                    <td>{{ $precio->tipoe }}</td>
                    <td>{{ $precio->tipove }}</td>
                    <td>${{ number_format($precio->precio, 2) }}</td>
                    <td>${{ number_format($precio->precio_promocion, 2) }}</td>
                    <td>
                        @if($precio->precio_promocion > $precio->precio)
                            Subió de precio
                        @elseif($precio->precio_promocion < $precio->precio)
                            Bajó de precio
                        @else
                            Nuevo
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
