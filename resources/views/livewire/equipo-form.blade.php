<div class="col-4">
    <form wire:submit.prevent="registrarEquipo">
        <div class="mb-3">
            <label for="imei">IMEI:</label>
            <input wire:model.defer="imei" type="text" class="form-control" required>
            @error('imei') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label for="marca">Marca/Modelo/Color/GB:</label>
            <input wire:model.defer="marca" type="text" class="form-control" required>
            @error('marca') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label for="tipoeq">Compañía:</label>
            <select wire:model="tipoeq" class="form-select">
                <option value="">Seleccione</option>
                @foreach($tiposEquipos as $tipo)
                    <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                @endforeach
            </select>
            @error('tipoeq') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label for="tipove">Tipo de Pago:</label>
            <select wire:model="tipove" class="form-select" id="tipove">
                <option value="">Seleccione</option>
                @foreach($tiposVentas as $tipo)
                    <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3" x-data="{ mostrar: \$wire.tipove == 2 }" x-show="mostrar">
            <label for="enganche">Enganche:</label>
            <input wire:model.defer="enganche" type="text" class="form-control">
        </div>

        <div class="mb-3">
            <label for="precio">Precio:</label>
            <input wire:model.defer="precio" type="text" class="form-control" required>
            @error('precio') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label for="numero">Número:</label>
            <input wire:model.defer="numero" type="text" class="form-control" required>
            @error('numero') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label for="id_vendedor">ID Vendedor:</label>
            <input wire:model.defer="id_vendedor" type="text" class="form-control" required>
            @error('id_vendedor') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="btn btn-primary">Registrar</button>
    </form>
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
