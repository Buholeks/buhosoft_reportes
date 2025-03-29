@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3>Editar Garantía</h3>

    <form method="POST" action="{{ route('garantias.update', $garantia->idtablagarantia) }}">
        @csrf
        @method('PUT')

        <div class="row mb-3">
            <div class="col-md-4">
                <label for="imei" class="form-label">IMEI</label>
                <input type="text" name="imei" class="form-control" value="{{ old('imei', $garantia->imei) }}" required>
            </div>
            <div class="col-md-4">
                <label for="marca" class="form-label">Marca</label>
                <input type="text" name="marca" class="form-control" value="{{ old('marca', $garantia->marca) }}" required>
            </div>
            <div class="col-md-4">
                <label for="cliente" class="form-label">Cliente</label>
                <input type="text" class="form-control" value="{{ $garantia->clientes->nombre ?? 'N/A' }}" disabled>
            </div>
        </div>

        <div class="mb-3">
            <label for="fallo" class="form-label">Fallo</label>
            <textarea name="fallo" class="form-control" required>{{ old('fallo', $garantia->fallo) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="accesorios" class="form-label">Accesorios</label>
            <textarea name="accesorios" class="form-control">{{ old('accesorios', $garantia->accesorios) }}</textarea>
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('garantias.index') }}" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-primary">Actualizar Garantía</button>
        </div>
    </form>
</div>
@endsection
