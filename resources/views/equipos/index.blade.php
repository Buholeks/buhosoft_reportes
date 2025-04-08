@extends('layouts.app')
@section('content')
    @vite(['resources/css/paginas.css'])

    <div class="container mt-2">
        <h4 class="mb-3 text-center">Administración de Equipos</h4>
        <!-- Filtros -->
        <div class="row m-2">
            @can('filtro equipos_admin')
                <form class="col-8" method="GET" action="{{ route('equipos.index') }}">
                    <div class="row g-3 col-12 p-2">
                        <div class="col-md-4"> <!-- Sucursal -->
                            <div class="col-md md-2">
                                <label for="sucursal">Sucursal</label>
                                <select name="id_sucursal" class="form-select form-control">
                                    <option value="">Todas</option>
                                    @foreach ($sucursales as $sucursal)
                                        <option value="{{ $sucursal->id }}"
                                            {{ request('id_sucursal') == $sucursal->id ? 'selected' : '' }}>
                                            {{ $sucursal->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Tipo de Equipo -->
                            <div class="col-md">
                                <label for="tipoeq">Tipo de Equipo</label>
                                <x-select-tipoventa name="tipoeq" />
                            </div>

                            <!-- Tipo de Venta -->
                            <div class="col-md">
                                <label for="tipove">Tipo de Venta</label>
                                <x-select-metodopago name="tipove" id="tipove" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <!-- Fechas -->
                            <div class="col-md">
                                <label for="fecha_inicio">Desde</label>
                                <input type="date" name="fecha_inicio" class="form-control"
                                    value="{{ request('fecha_inicio', date('Y-m-d')) }}">
                            </div>

                            <div class="col-md">
                                <label for="fecha_fin">Hasta</label>
                                <input type="date" name="fecha_fin" class="form-control"
                                    value="{{ request('fecha_fin', date('Y-m-d')) }}">
                            </div>
                            <!-- Botones -->
                            <div class="col-md mt-3">

                                <button type="submit" class="btn btn-primary ">
                                    <i class="fa-solid fa-search"></i> Buscar
                                </button>
                                <a href="{{ route('equipos.index') }}" class="btn btn-secondary">
                                    <i class="fa-solid fa-refresh"></i> Restablecer
                                </a>
                            </div>
                        </div>

                    </div>
                    <!-- IMEI -->
                    <div class="col-md-6">
                        <label for="imei">Buscar por IMEI</label>
                        <input type="text" name="imei" class="form-control" placeholder="Ingrese el IMEI"
                            value="{{ request('imei') }}">
                    </div>
                </form>
            @endcan
            <div class="col-4">
                <div class="col-md">
                    @can('exportar equipos_admin')
                        <form method="POST" id="export-form">
                            <h6>Exportar Seleccionado a:</h>
                                @csrf
                                <input type="hidden" name="equipos_seleccionados" id="equipos_seleccionados">
                                <input type="hidden" name="export_type" id="export_type">

                                <button type="button" class="btn btn-success p-1" onclick="exportData('excel')">
                                    <i class="fa-regular fa-file-excel fa-xl"></i></button>
                                <button type="button" class="btn btn-danger p-1" onclick="exportData('pdf')">
                                    <i class="fa-regular fa-file-pdf fa-xl"></i></button>
                        </form>
                    @endcan
                </div>
                @can('eliminar_seleccionados equipos_admin')
                    <div class="col-md-3">
                        <!-- ✅ Botón de eliminación fuera del <form> pero dentro de .acciones -->
                        <button type="button" class="btn btn-warning" onclick="eliminarSeleccionados()">Eliminar
                            Seleccionados</button>
                    </div>
                @endcan
            </div>
        </div>

        <!-- Tabla de Resultados -->
        <div class="table-responsive divtabla" style=" max-height: 500px;">
            <form style="padding: 0px; border:0;" method="POST" action="{{ route('equipos.seleccionados') }}"
                id="delete-form">
                @csrf
                <input type="hidden" name="equipos_seleccionados" id="equipos_seleccionados_delete">

                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="select-all"></th>
                            <th>FolioEmp.</th>
                            <th>FolioSuc.</th>
                            <th>IMEI</th>
                            <th>Marca/Modelo</th>
                            <th>Tipo de Producto</th>
                            <th>Método de Pago</th>
                            <th>Precio</th>
                            <th>Sucursal</th>
                            <th>Vendedor</th>
                            <th>Fecha Creación</th>
                            <th>Editar/Eliminar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($equipos as $equipo)
                            <tr id="fila-{{ $equipo->id }}">
                                <td>
                                    <input type="checkbox" name="equipos_seleccionados[]" value="{{ $equipo->id }}">
                                </td>
                                <td>{{ $equipo->folio_empresa }}</td>
                                <td>{{ $equipo->folio_sucursal }}</td>
                                <td>{{ $equipo->imei }}</td>
                                <td>{{ $equipo->marca }}</td>
                                <td>{{ $equipo->tipoproducto ? $equipo->tipoproducto->nombre : 'N/A' }}</td>
                                <td>{{ $equipo->metodopago ? $equipo->metodopago->nombre : 'N/A' }}</td>
                                <td>${{ number_format($equipo->precio, 2) }}</td>
                                <td>{{ $equipo->id_sucursal ? $equipo->sucursal->nombre : 'N/A' }}</td>
                                <td>{{ $equipo->id_vendedor ? $equipo->vendedores->nombre : 'N/A' }}</td>
                                <td>{{ $equipo->created_at }}</td>
                                <td>
                                    <!-- Editar -->
                                    @can('editar equipos_admin')
                                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#modalEditar" data-id="{{ $equipo->id }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    @endcan
                                    <!-- Eliminar -->
                                    @can('eliminar equipos_admin')
                                        <button type="button" class="btn btn-sm btn-danger btn-eliminar"
                                            data-id="{{ $equipo->id }}"
                                            data-url="{{ route('equipos.destroy', $equipo->id) }}">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    @endcan

                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">No hay resultados</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </form>
        </div>
    </div>

    <!-- Modal Editar -->
    <div class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="modalEditarLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="container modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditarLabel">Editar Equipo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <form id="formEditar" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <input type="hidden" name="id" id="editar_id">

                            <div class="col-5 mb-3">
                                <label for="editar_imei" class="form-label">IMEI</label>
                                <input type="text" class="form-control" name="imei" id="editar_imei">
                            </div>

                            <div class="col-10 mb-3">
                                <label for="editar_marca" class="form-label">Marca</label>
                                <input type="text" class="form-control" name="marca" id="editar_marca">
                            </div>
                            <div class="col-10 d-flex justify-content-around">
                                <div class="col-5 mb-3">
                                    <label for="editar_tipoeq_id" class="form-label">Tipo de Producto</label>
                                    <select class="form-select" name="tipoeq" id="editar_tipoeq_id">
                                        <option value="">Seleccione una opción</option>
                                        @foreach ($tiposEquipos as $tipoproducto)
                                            <option value="{{ $tipoproducto->id }}">{{ $tipoproducto->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-5 mb-3">
                                    <label for="editar_tipove_id" class="form-label">Método de Pago</label>
                                    <select class="form-select" name="tipove" id="editar_tipove_id">
                                        <option value="">Seleccione una opción</option>
                                        @foreach ($tiposVentas as $MetodoPago)
                                            <option value="{{ $MetodoPago->id }}">{{ $MetodoPago->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col d-flex justify-content-around">
                                <div class="col-3 mb-3">
                                    <label for="editar_precio" class="form-label">Precio</label>
                                    <input type="number" class="form-control" name="precio" id="editar_precio">
                                </div>

                                <div class="col-5 mb-3">
                                    <label for="editar_sucursal_id" class="form-label">Sucursal</label>
                                    <select class="form-select" name="id_sucursal" id="editar_sucursal_id">
                                        <option value="">Seleccione una opción</option>
                                        @foreach ($sucursales as $sucursal)
                                            <option value="{{ $sucursal->id }}">{{ $sucursal->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-3 mb-3">
                                    <label for="editar_fecha" class="form-label">fecha</label>
                                    <input type="date" class="form-control" name="fecha" id="editar_fecha">

                                </div>
                            </div>
                            <!-- Agrega más campos según tu modelo -->
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Guardar cambios</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modalEditar = document.getElementById('modalEditar');

            modalEditar.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const equipoId = button.getAttribute('data-id');

                fetch(`/equipos/${equipoId}/edit`)
                    .then(res => res.json())
                    .then(data => {
                        document.getElementById('editar_id').value = data.id;
                        document.getElementById('editar_imei').value = data.imei;
                        document.getElementById('editar_marca').value = data.marca;
                        document.getElementById('editar_precio').value = data.precio;
                        document.getElementById('editar_fecha').value = data.created_at_formatted ?? '';

                        // Setea los valores seleccionados
                        document.getElementById('editar_tipoeq_id').value = data.tipoeq ?? '';
                        document.getElementById('editar_tipove_id').value = data.tipove ?? '';
                        document.getElementById('editar_sucursal_id').value = data.id_sucursal ?? '';

                        // Actualiza la acción del formulario
                        document.getElementById('formEditar').action = `/equipos/${data.id}`;
                    });

            });
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const checkboxes = document.querySelectorAll("input[name='equipos_seleccionados[]']");
            const inputHidden = document.getElementById("equipos_seleccionados");
            const inputHiddenDelete = document.getElementById("equipos_seleccionados_delete");
            const selectAllCheckbox = document.getElementById("select-all");
            const exportForm = document.getElementById("export-form");
            const deleteForm = document.getElementById("delete-form");
            const routeExcel = "{{ route('equipos.export.excel') }}";
            const routePDF = "{{ route('equipos.export.pdf') }}";

            function actualizarSeleccionados() {
                const seleccionados = Array.from(checkboxes)
                    .filter(checkbox => checkbox.checked)
                    .map(checkbox => checkbox.value);

                inputHidden.value = JSON.stringify(seleccionados);
                inputHiddenDelete.value = JSON.stringify(seleccionados);
            }

            if (selectAllCheckbox) {
                selectAllCheckbox.addEventListener("change", function() {
                    checkboxes.forEach(checkbox => {
                        checkbox.checked = selectAllCheckbox.checked;
                    });
                    actualizarSeleccionados();
                });
            }

            checkboxes.forEach(checkbox => {
                checkbox.addEventListener("change", actualizarSeleccionados);
            });

            // ✅ SweetAlert para exportación
            window.exportData = function(type) {
                actualizarSeleccionados();

                if (inputHidden.value === "[]") {
                    Swal.fire({
                        icon: 'warning',
                        title: '¡Atención!',
                        text: 'Por favor, selecciona al menos un equipo.',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                Swal.fire({
                    title: '¿Estás seguro?',
                    text: `Se exportarán los equipos seleccionados a ${type.toUpperCase()}.`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, exportar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        exportForm.setAttribute("action", type === 'excel' ? routeExcel : routePDF);
                        exportForm.submit();
                    }
                });
            };

            // ✅ SweetAlert para eliminación
            window.eliminarSeleccionados = function() {
                actualizarSeleccionados();

                if (inputHiddenDelete.value === "[]") {
                    Swal.fire({
                        icon: 'warning',
                        title: '¡Atención!',
                        text: 'Por favor, selecciona al menos un equipo para eliminar.',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "Esta acción no se puede deshacer.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        deleteForm.submit();
                    }
                });
            };
        });
    </script>
@endsection
