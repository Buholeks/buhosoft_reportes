@extends('layouts.app')
@section('content')
    <div class="container mt-4">
        <h4 class="mb-3 text-center">Reporte de Comisiones</h4>

        <!-- Filtros -->
        <form method="GET" action="{{ route('comisiones.index') }}" class="row g-3 mb-4">
            <div class="col-md-3">
                <label>Mes:</label>
                <input type="month" name="mes" class="form-control" value="{{ request('mes', now()->format('Y-m')) }}">
            </div>
            <div class="col-md-3">
                <label>Sucursal:</label>
                <select name="id_sucursal" class="form-control">
                    <option value="">Todas</option>
                    @foreach ($sucursales as $sucursal)
                        <option value="{{ $sucursal->id }}" {{ request('id_sucursal') == $sucursal->id ? 'selected' : '' }}>
                            {{ $sucursal->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label>Vendedor:</label>
                <select name="id_vendedor" class="form-control">
                    <option value="">Todos</option>
                    @foreach ($vendedores as $vendedor)
                        <option value="{{ $vendedor->id }}" {{ request('id_vendedor') == $vendedor->id ? 'selected' : '' }}>
                            {{ $vendedor->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">Filtrar</button>
            </div>
            <div class="col-md-3">
                <label>Comisión ≥ $1000:</label>
                <input type="number" step="0.01" name="comision_mayor" class="form-control"
                    value="{{ request('comision_mayor', 30) }}">
            </div>
            <div class="col-md-3">
                <label>Comisión < $1000:</label>
                        <input type="number" step="0.01" name="comision_menor" class="form-control"
                            value="{{ request('comision_menor', 20) }}">
            </div>
        </form>

        <!-- Tabla de resumen -->
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Vendedor</th>
                    <th>Total Equipos</th>
                    <th>Total Ventas</th>
                    <th>Total Comisión</th>
                    <th>Detalle</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($datos as $vendedor)
                    <tr>
                        <td>{{ $vendedor['vendedor'] }}</td>
                        <td>{{ $vendedor['total_equipos'] }}</td>
                        <td>${{ number_format($vendedor['total_ventas'], 2) }}</td>
                        <td>${{ number_format($vendedor['total_comision'], 2) }}</td>
                        <td>
                            <button class="btn btn-sm btn-info" type="button" data-bs-toggle="collapse"
                                data-bs-target="#detalle-{{ $loop->index }}">Ver</button>
                        </td>
                    </tr>
                    <tr class="collapse" id="detalle-{{ $loop->index }}">
                        <td colspan="5">
                            <table class="table table-sm table-hover">
                                <thead>
                                    <tr>
                                        <th>Marca</th>
                                        <th>Precio</th>
                                        <th>Fecha</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($vendedor['detalle'] as $equipo)
                                        <tr>
                                            <td>{{ $equipo->marca }}</td>
                                            <td>${{ number_format($equipo->precio, 2) }}</td>
                                            <td>{{ $equipo->created_at }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @if (empty($datos))
            <p class="text-center text-muted mt-4">Usa los filtros para ver las comisiones.</p>
        @else
            <!-- Gráfica (opcional si usas Chart.js) -->
            <div class="mt-5">
                <canvas id="graficaComisiones"></canvas>
            </div>
        @endif

    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('graficaComisiones').getContext('2d');

        const chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json(array_column($datos, 'vendedor')),
                datasets: [{
                    label: 'Comisión Total',
                    data: @json(array_column($datos, 'total_comision')),
                    backgroundColor: 'rgba(54, 162, 235, 0.6)'
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Comisiones por Vendedor'
                    }
                }
            }
        });
    </script>
@endsection
