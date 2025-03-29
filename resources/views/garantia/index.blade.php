@extends('layouts.app')
@section('content')
@vite(['resources/css/paginas.css'])
<div class="divtabla container mt-2">
    <div class="row">
        <div class="col-4">
            <!-- Botón para Agregar Nueva Garantía -->
            @can('nueva garantia')
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalGarantia">
                <i class="fa fa-plus"></i> Nueva Garantía
            </button>
            @endcan
        </div>
        <div class="col-6">
            <h3>Registro de Garantías</h3>
        </div>
    </div>

    <!-- Tabla de Garantías -->
    <table class="table table-hover mt-3">
        <thead>
            <tr>
                <th>IMEI</th>
                <th>Marca</th>
                <th>Cliente</th>
                <th>Status</th>
                <th>Fecha de Ingreso</th>
                <th>Acciones</th>

            </tr>
        </thead>
        <tbody id="tabla-garantias">
            @foreach($garantias as $garantia)
            <tr id="fila-{{ $garantia->idtablagarantia }}">
                <td>{{ $garantia->imei }}</td>
                <td>{{ $garantia->marca }}</td>
                <td>{{ $garantia->clientes ? $garantia->clientes->nombre : 'N/A' }}</td>
                <td>{{ $garantia->estado }}</td>
                <td>{{ $garantia->created_at }}</td>
                <td>
                    <a href="{{ route('garantias.show', $garantia->idtablagarantia) }}" class="btn btn-sm btn-warning">
                        <i class="fa-solid fa-truck-arrow-right fa-xl"></i>
                    </a>
                    @can('editar garantia')
                    <a href="{{ route('garantias.edit', $garantia->idtablagarantia) }}" class="btn btn-sm btn-warning">
                        <i class="fa fa-edit"></i>
                    </a>
                    @endcan
                    <!-- Eliminar -->
                    @can('eliminar garantia')
                    <button class="btn btn-danger btn-sm btn-eliminar"
                        data-id="{{ $garantia->idtablagarantia }}"
                        data-url="{{ route('garantias.destroy', $garantia->idtablagarantia) }}">
                        <i class="fa fa-trash"></i>
                    </button>
                    @endcan

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>

<!-- Modal -->
<div class="modal fade modal-lg" id="modalGarantia" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Registrar Garantía</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formGarantia" method="POST" action="{{ route('garantias.store') }}">
                    @csrf
                    <div class="row">
                        <div class="mb-3 col-3">
                            <label for="imei" class="form-label">IMEI</label>
                            <input type="text" name="imei" class="form-control" required>
                        </div>
                        <div class="mb-3 col-5">
                            <label for="marca" class="form-label">Marca</label>
                            <input type="text" name="marca" class="form-control" required>
                        </div>
                        <div class="mb-3 col-4">
                            <!-- buscar vendedor -->
                            <div class="mb-3 position-relative">
                                <label for="cliente" class="form-label">Cliente</label>
                                <input type="text" id="search" class="form-control cliente" data-search-url="{{ route('buscar-clientes') }}" data-hidden-input-id="hidden_input_cliente" placeholder="Buscar cliente...">
                                <input type="hidden" id="hidden_input_cliente" name="id_cliente">
                            </div>
                        </div>
                    </div>
                    <!-- buscar vendedor -->

                    <div class="mb-3 position-relative">
                        <label for="">¿Quien recibe la Garantía?</label>
                        <input type="text" id="search" class="form-control vendedor" data-search-url="{{ route('buscar-vendedores') }}" data-hidden-input-id="hidden_input_vendedor" placeholder="Busca tu Nombre...">
                        <input type="hidden" id="hidden_input_vendedor" name="id_vendedor">
                    </div>

                    <div class="mb-3">
                        <label for="fallo" class="form-label">Fallo</label>
                        <textarea name="fallo" class="form-control" placeholder="Describe el fallo que tiene y tambien que tipo de chequeo hicieron ustedes" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="accesorios" class="form-label">Accesorios</label>
                        <textarea name="accesorios" class="form-control" placeholder="anota todos los accesorios que el cliente deja, asi como con o sin cargador, cable, caja, funda, bandeja de sim, etc."></textarea>
                    </div>
                    <!-- <input type="hidden" id="garantiaId"> -->
                    <button type="submit" class="btn btn-success">Guardar</button>
                </form>

            </div>
        </div>
    </div>
</div>

@endsection