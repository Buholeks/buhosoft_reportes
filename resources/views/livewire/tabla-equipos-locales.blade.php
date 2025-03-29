<div class="table-responsive mt-4">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Folio</th>
                <th>IMEI</th>
                <th>Marca/Modelo</th>
                <th>Tipo de Equipo</th>
                <th>Método de Pago</th>
                <th>Precio</th>
                <th>Enganche</th>
                <th>Número</th>
                <th>Vendedor</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            @foreach($equipos as $equipo)
                <tr>
                    <td>{{ $equipo->folio_sucursal }}</td>
                    <td>{{ $equipo->imei }}</td>
                    <td>{{ $equipo->marca }}</td>
                    <td>{{ $equipo->tipoproducto->nombre ?? 'N/A' }}</td>
                    <td>{{ $equipo->metodopago->nombre ?? 'N/A' }}</td>
                    <td>${{ number_format($equipo->precio, 2) }}</td>
                    <td>{{ $equipo->enganche ?? '-' }}</td>
                    <td>{{ $equipo->numero }}</td>
                    <td>{{ $equipo->vendedores->nombre ?? 'N/A' }}</td>
                    <td>{{ $equipo->created_at->format('Y-m-d') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
