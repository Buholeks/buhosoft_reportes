<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Listado de Equipos</title>

    {{-- Bootstrap desde CDN (domPDF lo soporta en parte) --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <style>
        body {
            font-size: 12px;
            margin: 20px;
        }

        .encabezado {
            border-bottom: 2px solid #000;
            margin-bottom: 20px;
            padding-bottom: 10px;
        }

        .empresa {
            font-size: 20px;
            font-weight: bold;
        }

        .sucursal-info {
            font-size: 12px;
        }

        .table thead {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .table td,
        .table th {
            padding: 5px;
            vertical-align: middle;
        }
    </style>
</head>

<body>
<div style="width: 100%; border-bottom: 2px solid #000; margin-bottom: 20px; padding-bottom: 10px; display: table;">
    {{-- Columna izquierda (texto) --}}
    <div style="display: table-cell; width: 70%; vertical-align: middle;">
        <div style="font-size: 20px; font-weight: bold;">
            {{ $empresa->nom_empresa ?? 'Nombre de la Empresa' }}
        </div>
        <div style="font-size: 12px;">
            <strong>Sucursal:</strong> {{ $sucursal->nombre ?? 'Sucursal' }}<br>
            <strong>Dirección:</strong> {{ $sucursal->direccion ?? 'Dirección' }}<br>
            <strong>Teléfono:</strong> {{ $sucursal->numero_tel ?? '000-000-0000' }}
        </div>
    </div>

    {{-- Columna derecha (logo) --}}
    <div style="display: table-cell; width: 30%; text-align: right; vertical-align: middle;">
        <img src="{{ public_path('imagenes/logopgweb.png') }}" width="120" alt="Logo de la empresa">
    </div>
</div>

    <table class="table table-bordered table-sm">
        <thead>
            <tr>
                <th>Folio Empresa</th>
                <th>Folio Local</th>
                <th>IMEI</th>
                <th>Marca/Modelo</th>
                <th>Tipo de Producto</th>
                <th>Método de Pago</th>
                <th>Precio</th>
                <th>Sucursal</th>
                <th>Fecha Creación</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($equipos as $equipo)
            <tr>
                <td>{{ $equipo->folio_empresa }}</td>
                <td>{{ $equipo->folio_sucursal }}</td>
                <td>{{ $equipo->imei }}</td>
                <td>{{ $equipo->marca }}</td>
                <td>{{ $equipo->tipoproducto->nombre ?? 'N/A' }}</td>
                <td>{{ $equipo->metodopago->nombre ?? 'N/A' }}</td>
                <td>${{ number_format($equipo->precio, 2) }}</td>
                <td>{{ $equipo->sucursal->nombre ?? 'N/A' }}</td>
                <td>{{ \Carbon\Carbon::parse($equipo->created_at)->format('d/m/Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>