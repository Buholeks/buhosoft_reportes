@extends('layouts.app')
@section('content')
@vite(['resources/css/paginas.css'])
<div class="container mt-4 ">
    <h3>Seguimiento de Garantías</h3>
    <table class="table table-hover">
        <thead>
            <tr>
                <th>IMEI</th>
                <th>Marca</th>
                <th>Sucursal</th>
                <th>Cliente</th>
                <th>Estado</th>
                <th>Actualizar Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($garantias as $garantia)
            <tr>
                <td>{{ $garantia->imei }}</td>
                <td>{{ $garantia->marca }}</td>
                <td>{{ $garantia->sucursal->nombre ?? 'N/A' }}</td>
                <td>{{ $garantia->clientes->nombre ?? 'N/A' }}</td>
                <td><strong>{{ $garantia->estado }}</strong></td>
                <td>
                    <form method="POST"
                        style="padding: 0px; border:0;"
                        class="form-cambio-estado d-flex align-items-center gap-2 "
                        data-url="{{ url('/garantia/cambiar-status/' . $garantia->idtablagarantia) }}">

                        @csrf

                        <select name="estado" class="form-select form-select-sm ">
                            <option value="Recogido en Sucursal">Recogido en Sucursal</option>
                            <option value="Recibido en Matriz">Recibido en Matriz</option>
                            <option value="en Revision">en Revision</option>
                            <option value="esperando respuesta">Esperando Respuesta</option>
                            <option value="Devuelta a Matriz">Devuelta a Matriz</option>
                            <option value="Enviado a Sucursal">Enviado a Sucursal</option>
                        </select>

                        <button type="submit" class="btn btn-sm btn-success">Actualizar</button>
                    </form>
                </td>

            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
    document.querySelectorAll('.form-cambio-estado').forEach(form => {
        form.addEventListener('submit', async function(e) {
            e.preventDefault();

            const url = this.getAttribute('data-url');
            const formData = new FormData(this);

            try {
                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': formData.get('_token'),
                        'Accept': 'application/json'
                    },
                    body: formData
                });

                if (!response.ok) {
                    throw new Error(`HTTP ${response.status}`);
                }

                const data = await response.json();

                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Estado actualizado!',
                        text: `Nuevo estado: ${data.nuevo_estado}`,
                        timer: 2000,
                        showConfirmButton: false
                    });

                    // Esperamos 2 segundos antes de recargar la tabla
                    setTimeout(() => location.reload(), 2000);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'No se pudo actualizar el estado.'
                    });
                }

            } catch (error) {
                console.error('Error en el fetch:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error en la petición',
                    text: error.message
                });
            }
        });
    });
</script>


@endsection