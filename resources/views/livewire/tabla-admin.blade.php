@vite(['resources/css/paginas.css'])
<div class="container mt-2">
    <h4 class="mb-3 text-center">Administración de Equipos</h4>

    <!-- Filtros -->
    <div class="row m-2">
        <div class="col-md-8">
            <div class="row g-3">
                <div class="col-md-4">
                    <label>Sucursal</label>
                    <select wire:model="id_sucursal" class="form-select">
                        <option value="">Todas</option>
                        @foreach($sucursales as $sucursal)
                            <option value="{{ $sucursal->id }}">{{ $sucursal->nombre }}</option>
                        @endforeach
                    </select>

                    <label class="mt-2">Tipo de Equipo</label>
                    <select wire:model="tipoeq" class="form-select">
                        <option value="">Todos</option>
                        @foreach($tiposEquipos as $tipo)
                            <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                        @endforeach
                    </select>

                    <label class="mt-2">Método de Pago</label>
                    <select wire:model="tipove" class="form-select">
                        <option value="">Todos</option>
                        @foreach($tiposVentas as $metodo)
                            <option value="{{ $metodo->id }}">{{ $metodo->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label>Desde</label>
                    <input type="date" wire:model="fecha_inicio" class="form-control">
                    <label class="mt-2">Hasta</label>
                    <input type="date" wire:model="fecha_fin" class="form-control">
                </div>
                <div class="col-md-4">
                    <label>Buscar por IMEI</label>
                    <input type="text" wire:model.debounce.300ms="imei" class="form-control" placeholder="Ingrese el IMEI">

                    <div class="mt-3">
                        <button wire:click="exportar('excel')" class="btn btn-success"><i class="fa fa-file-excel"></i> Excel</button>
                        <button wire:click="exportar('pdf')" class="btn btn-danger"><i class="fa fa-file-pdf"></i> PDF</button>
                        <button wire:click="eliminarSeleccionados" class="btn btn-warning"><i class="fa fa-trash"></i> Eliminar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla -->
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th><input type="checkbox" wire:model="selectAll"></th>
                    <th>FolioEmp.</th>
                    <th>FolioSuc.</th>
                    <th>IMEI</th>
                    <th>Marca/Modelo</th>
                    <th>Tipo de Producto</th>
                    <th>Método de Pago</th>
                    <th>Precio</th>
                    <th>Sucursal</th>
                    <th>Fecha</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($equipos as $equipo)
                    <tr>
                        <td><input type="checkbox" value="{{ $equipo->id }}" wire:model="seleccionados"></td>
                        <td>{{ $equipo->folio_empresa }}</td>
                        <td>{{ $equipo->folio_sucursal }}</td>
                        <td>{{ $equipo->imei }}</td>
                        <td>{{ $equipo->marca }}</td>
                        <td>{{ $equipo->tipoproducto->nombre ?? 'N/A' }}</td>
                        <td>{{ $equipo->metodopago->nombre ?? 'N/A' }}</td>
                        <td>${{ number_format($equipo->precio, 2) }}</td>
                        <td>{{ $equipo->sucursal->nombre ?? 'N/A' }}</td>
                        <td>{{ $equipo->created_at }}</td>
                        <td>
                            <button class="btn btn-sm btn-primary" wire:click="$emit('editarEquipo', {{ $equipo->id }})"><i class="fas fa-edit"></i></button>
                            <button class="btn btn-sm btn-danger" wire:click="$emit('confirmarEliminacion', {{ $equipo->id }})"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="11" class="text-center">No hay resultados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        {{ $equipos->links() }}
    </div>
</div>

@push('scripts')
<script>
    window.addEventListener('alerta', e => {
        Swal.fire({
            icon: e.detail.tipo || 'info',
            title: e.detail.mensaje,
            timer: 2000,
            showConfirmButton: false
        });
    });
</script>
@endpush