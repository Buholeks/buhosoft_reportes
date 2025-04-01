@vite([ 'resources/js/app.js'])
<style>
    body {
        display: flex;
        justify-content: center;

    }

    select:hover,
    button:hover {
        cursor: pointer;
        box-shadow: 0 0 25px rgb(53, 114, 255);
    }


    #suc {
        display: flex;
        align-items: center;
    }
</style>
<div style="text-align: center; margin-top: 15%;">
    <h2>Seleccione una Sucursal</h2>
    <p></p>
    <form action="{{ route('vista_sucursal.post') }}" method="POST">
        @csrf
        <div id="suc">
            <i class="fa-regular fa-building fa-bounce fa-2x" style="margin-right: 10px;"></i>
            <select style="width: 400px;" class="form-control" name="sucursal_id" id="sucursal" required>
                <option value="">Seleccione Aquí</option>
                @foreach($sucursales as $sucursal)
                <option value="{{ $sucursal['id'] }}">{{ $sucursal['nombre'] }}</option>
                @endforeach
            </select>
        </div>
        <p></p>
        <button class="btn btn-primary" id="btiniciarsesion" type="submit">Seleccionar</button>
    </form>
</div>