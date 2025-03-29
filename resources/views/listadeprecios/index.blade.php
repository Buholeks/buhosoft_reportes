{{-- resources/views/listadeprecios/index.blade.php --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@vite(['resources/css/paginas.css'])
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Lista de Precios</h2>

    {{-- Botón para abrir el modal de Crear --}}
    @can('crear_nuevo precio')
    <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#modalCrear"><i class="fa-solid fa-plus"></i> Nuevo</button>
    @endcan
    <div class="input-group mb-3">
        <span class="input-group-text"><i class="fas fa-search"></i></span>
        <input type="text" id="busqueda" class="form-control" placeholder="Buscar...">
    </div>



    <div class="divtabla col-12 mt-3 px-0" style="height:450px;">
        {{-- Tabla con listado de precios --}}
        <table class="table table-hover">
            <thead>
                <th>Descripción</th>
                <th>Tipo Equipo</th>
                <th>Tipo Venta</th>
                <th>Precio Antes</th>
                <th>Precio Ahora</th>
                <th>Última Actualización</th>
                <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($listadeprecios as $precio)
                <tr>
                    <td>{{ $precio->descripcion }}</td>
                    <td>{{ $precio->tipoproducto ? $precio->tipoproducto->nombre : 'N/A' }}</td>
                    <td>{{ $precio->metodopago ? $precio->metodopago->nombre : 'N/A' }}</td>
                    <td>${{ number_format($precio->precio, 2) }}</td>
                    <td>${{ number_format($precio->precio_promocion, 2) }}</td>
                    <td>{{ $precio->updated_at }}</td>
                    <td>
                        <!-- Editar -->
                        @can('editar precio')
                        <button type="button" class="btn btn-sm btn-primary"
                            data-bs-toggle="modal"
                            data-bs-target="#modalEditar"
                            data-id="{{ $precio->id }}">
                            <i class="fas fa-edit"></i>
                        </button>
                        @endcan
                        <!-- Eliminar -->
                        @can('eliminar precio')
                        <button type="button" class="btn btn-sm btn-danger btn-eliminar"
                            data-id="{{ $precio->id }}">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                        @endcan
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
{{-- Modal Crear --}}
<div class="modal fade" id="modalCrear" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            @php
            use App\Models\Listadeprecios;
            use App\Models\TipoProducto;
            use App\Models\MetodoPago;

            $registro = new Listadeprecios();
            $modo = 'Crear';
            $tiposEquipos = TipoProducto::all();
            $tiposVentas = MetodoPago::all();
            @endphp

            <form method="POST" action="{{ route('listadeprecios.store') }}">
                @csrf
                @include('listadeprecios._form', compact('registro', 'modo', 'tiposEquipos', 'tiposVentas'))
            </form>
        </div>
    </div>
</div>

<!-- Modal Editar -->
<div class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="modalEditarLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="formEditar" method="POST">
                @csrf
                @method('PUT')

                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditarLabel">Editar Equipo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="id" id="editar_id">

                    <div class="mb-3">
                        <label for="editar_descripcion" class="form-label">descripcion</label>
                        <input type="text" class="form-control" name="descripcion" id="editar_descripcion">
                    </div>
                    <div class="mb-3">
                        <label for="editar_tipoeq_id" class="form-label">Tipo de Producto</label>
                        <select class="form-select" name="tipoe" id="editar_tipoeq_id">
                            <option value="">Seleccione una opción</option>
                            @foreach($tiposEquipos as $tipoproducto)
                            <option value="{{ $tipoproducto->id }}">{{ $tipoproducto->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="editar_tipove_id" class="form-label">Método de Pago</label>
                        <select class="form-select" name="tipove" id="editar_tipove_id">
                            <option value="">Seleccione una opción</option>
                            @foreach($tiposVentas as $MetodoPago)
                            <option value="{{ $MetodoPago->id }}">{{ $MetodoPago->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="editar_preciopromocion" class="form-label">Actualizar Precio</label>
                        <input type="number" class="form-control" name="precio_promocion" id="editar_preciopromocion">
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


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modalEditar = document.getElementById('modalEditar');

        modalEditar.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const precio = button.getAttribute('data-id');

            fetch(`/listadeprecios/${precio}/edit`)
                .then(res => res.json())
                .then(data => {
                    document.getElementById('editar_id').value = data.id;
                    document.getElementById('editar_descripcion').value = data.descripcion;
                    document.getElementById('editar_preciopromocion').value = data.precio_promocion;

                    // Setea los valores seleccionados
                    document.getElementById('editar_tipoeq_id').value = data.tipoeq;
                    document.getElementById('editar_tipove_id').value = data.tipove;

                    // Actualiza la acción del formulario
                    document.getElementById('formEditar').action = `/listadeprecios/${data.id}`;
                });

        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const eliminarBtns = document.querySelectorAll('.btn-eliminar');

        eliminarBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const precioId = this.getAttribute('data-id');

                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "¡Esto no se puede deshacer!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Crear formulario y enviarlo
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = `/listadeprecios/${precioId}`;

                        const csrf = document.createElement('input');
                        csrf.type = 'hidden';
                        csrf.name = '_token';
                        csrf.value = '{{ csrf_token() }}';

                        const method = document.createElement('input');
                        method.type = 'hidden';
                        method.name = '_method';
                        method.value = 'DELETE';

                        form.appendChild(csrf);
                        form.appendChild(method);
                        document.body.appendChild(form);
                        form.submit();
                    }
                });
            });
        });
    });
</script>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const inputBusqueda = document.getElementById('busqueda');
        const filas = document.querySelectorAll('table tbody tr');

        inputBusqueda.addEventListener('keyup', function() {
            const texto = this.value.toLowerCase();

            filas.forEach(fila => {
                const contenidoFila = fila.textContent.toLowerCase();
                fila.style.display = contenidoFila.includes(texto) ? '' : 'none';
            });
        });
    });
</script>

@endsection