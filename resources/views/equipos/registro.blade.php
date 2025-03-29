@extends('layouts.app')
@section('content')
@vite(['resources/css/paginas.css'])

<div class="container mt-4">
    <div class="row">
        <!-- Contenedor 1: Dos columnas internas -->
        @can('registrar equipos_local')
        <div class="col-4">
            <form id="VentaEquipos" method="POST" action="{{ route('equipos.store') }}">
                @csrf
                <!-- imei -->
                <div class="mb-3" style="display: inline-flex;">
                    <label for="imei">IMEI:</label>
                    <input class="form-control imei" type="text" name="imei" required>
                </div>
                <!-- marca -->
                <div class="mb-3" style="display: inline-grid;">
                    <label for="marca">Marca/Modelo/Color/GB:</label>
                    <input class="form-control marca" type="text" name="marca" required>
                </div>
                <!-- tipo de venta y tipo equipo -->
                <div class="mb-3">
                    <div style="display: inline-grid;">
                        <label for="tipoeq">Compañía:</label>
                        <!-- tipove es el nombre o el id digamos del select para pasar los datos al formulario -->
                        <x-select-tipoventa name="tipoeq" />
                    </div>

                    <div style="display: inline-grid;">
                        <!-- tipove es el nombre o el id digamos del select para pasar los datos al formulario -->
                        <label for="tipove">Tipo de pago:</label>
                        <x-select-metodopago name="tipove" id="tipove" />
                    </div>

                    <!-- Contenedor para el input "enganche", oculto inicialmente -->
                    <div class="mb-3" id="engancheContainer" style="display: none; width: 10px;">
                        <label for="">Enganche</label>
                        <input class="form-control" style="background-color: hotpink;" type="text" name="enganche" id="enganche" placeholder="$">
                    </div>

                </div>
                <!-- precio y numero -->
                <div class="mb-3" style="display: flex;justify-content: space-evenly;">
                    <div style="display: inline-grid;">
                        <label for="precio">Precio:</label>
                        <input class="form-control precio" type="text" name="precio" required>
                    </div>

                    <div style="display: inline-grid;">
                        <label for="numero">Número:</label>
                        <input class="form-control numero" type="text" name="numero" required>
                    </div>

                </div>
                <!-- buscar vendedor -->
                <div class="mb-3 position-relative">
                    <input type="text" id="search" class="form-control vendedor" data-search-url="{{ route('buscar-vendedores') }}" data-hidden-input-id="hidden_input" placeholder="Buscar Vendedor...">
                    <input type="hidden" id="hidden_input" name="id_vendedor">
                </div>

                <button type="submit" class="btn btn-primary">Registrar</button>
            </form>
        </div>
        @endcan
        <div class="divtabla col-7 px-0" style=" max-height: 300px;">
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
                    @foreach($precios as $precios)
                    <tr class="{{ $precios->precio_promocion > $precios->precio ? 'table-danger' : ($precios->precio_promocion < $precios->precio ? 'table-success' : 'table-ligth') }}">
                        <td>{{ $precios->descripcion }}</td>
                        <td>{{ $precios->tipoproducto ? $precios->tipoproducto->nombre : 'N/A' }}</td>
                        <td>{{ $precios->metodopago ? $precios->metodopago->nombre : 'N/A' }}</td>
                        <td>{{ $precios->precio }}</td>
                        <td>{{ $precios->precio_promocion }}</td>
                        <td>
                            @if($precios->precio_promocion > $precios->precio)
                            Subió de precio
                            @elseif($precios->precio_promocion < $precios->precio)
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
        <!-- Contenedor 2: Un solo contenedor -->


    </div>
    <div class="divtabla col-12 mt-3 px-0" style=" height:380px;">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Folio</th>
                    <th>IMEI</th>
                    <th>Marca/Modelo</th>
                    <th>Tipo de Equipo</th>
                    <th>Metodo de Pago</th>
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
                    <td>{{ $equipo->tipoproducto ? $equipo->tipoproducto->nombre : 'N/A' }}</td>
                    <td>{{ $equipo->metodopago ? $equipo->metodopago->nombre : 'N/A' }}</td>
                    <td>{{ $equipo->precio }}</td>
                    <td>{{ $equipo->enganche }}</td>
                    <td>{{ $equipo->numero }}</td>
                    <td>{{ $equipo->vendedores ? $equipo->vendedores->nombre : 'N/A' }}</td>
                    <td>{{ $equipo->created_at }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tipoPago = document.getElementById('tipove');
        const engancheContainer = document.getElementById('engancheContainer');

        function toggleEnganche() {
            console.log('Valor del select:', tipoPago.value); // Para depuración
            if (tipoPago.value === '2') { // Se muestra si el ID seleccionado es "2"
                engancheContainer.style.display = 'inline-grid';
            } else {
                engancheContainer.style.display = 'none';
            }
        }

        toggleEnganche();
        tipoPago.addEventListener('change', toggleEnganche);
    });
</script>

<style>
    .active {
        background-color: #d4d4d4;
    }

    #results li {
        cursor: pointer;
    }
</style>
@endsection